<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Paiement;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class FactureController extends Controller
{
    /**
     * Affiche la liste des factures
     */
    public function index()
    {
        $factures = Facture::with('paiement.reservation.locataire', 'paiement.reservation.chambre')->get();
        return view('factures.index', compact('factures'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $paiements = Paiement::with('reservation.locataire', 'reservation.chambre', 'reservation.paiements')->get();
        return view('factures.create', compact('paiements'));
    }

    /**
     * Enregistre une nouvelle facture
     */
    public function store(Request $request)
    {
        $request->validate([
            'paiement_id'   => 'required|exists:paiements,id',
            'montant_total' => 'required|numeric|min:0',
            'montant_paye'  => 'required|numeric|min:0',
            'reste'         => 'required|numeric|min:0',
            'date_facture'  => 'required|date',
        ]);

        // Trouver le paiement et sa réservation
        $paiement = Paiement::with('reservation.chambre', 'reservation.locataire', 'reservation.paiements')->findOrFail($request->paiement_id);
        $reservation = $paiement->reservation;

        // Recalcul du montant total pour sécurité
        $dateArrivee = \Carbon\Carbon::parse($reservation->date_arrivee);
        $dateDepart   = \Carbon\Carbon::parse($reservation->date_depart);
        $nbNuits   = $dateArrivee->diffInDays($dateDepart);
        $montantTotal = $nbNuits * $reservation->chambre->prix;

        $montantPaye = $reservation->acompte + $reservation->paiements->sum('montant');
        $reste = $montantTotal - $montantPaye;

        $facture = Facture::create([
            'paiement_id'   => $paiement->id,
            'reservation_id'=> $reservation->id,
            'montant_total' => $montantTotal,
            'montant_paye'  => $montantPaye,
            'reste'         => $reste,
            'date_facture'  => $request->date_facture,
        ]);

        return redirect()->route('factures.index')->with('success', 'Facture générée avec succès.');
    }

    /**
     * Affiche une facture
     */
    public function show(Facture $facture)
    {
        $facture->load('paiement.reservation.locataire', 'paiement.reservation.chambre');
        return view('factures.show', compact('facture'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit(Facture $facture)
    {
        $paiements = Paiement::with('reservation.locataire', 'reservation.chambre')->get();
        return view('factures.edit', compact('facture', 'paiements'));
    }

    /**
     * Met à jour une facture
     */
    public function update(Request $request, Facture $facture)
    {
        $request->validate([
            'paiement_id'   => 'required|exists:paiements,id',
            'montant_total' => 'required|numeric|min:0',
            'montant_paye'  => 'required|numeric|min:0',
            'reste'         => 'required|numeric|min:0',
            'date_facture'  => 'required|date',
        ]);

        $facture->update($request->all());

        return redirect()->route('factures.index')->with('success', 'Facture mise à jour avec succès.');
    }

    /**
     * Supprime une facture
     */
    public function destroy(Facture $facture)
    {
        $facture->delete();
        return redirect()->route('factures.index')->with('success', 'Facture supprimée avec succès.');
    }

    public function generatePDF(Facture $facture)
{
    $facture->load('paiement.reservation.locataire', 'paiement.reservation.chambre');

    $pdf = Pdf::loadView('factures.pdf', compact('facture'));

    $fileName = "facture_{$facture->id}.pdf";

    return $pdf->download($fileName);
}
}
