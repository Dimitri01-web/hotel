<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Reservation;
use App\Models\Facture;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaiementController extends Controller
{
    /**
     * Liste des paiements
     */
    public function index()
    {
        $paiements = Paiement::with('reservation.locataire', 'reservation.chambre')->get();
        return view('paiements.index', compact('paiements'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $reservations = Reservation::with('locataire', 'chambre')->get();
        return view('paiements.create', compact('reservations'));
    }

    /**
     * Enregistrement d’un paiement + génération facture
     */

        public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'montant'        => 'required|numeric|min:0',
            'mode_paiement'  => 'required|string|max:50',
            'date_paiement'  => 'required|date',
            'reference'      => 'nullable|string|max:100',
        ]);

        // Charger la réservation
        $reservation = Reservation::with('chambre')->findOrFail($request->reservation_id);

        // Calcul du montant dû
        $dateDebut = Carbon::parse($reservation->date_arrivee);
        $dateFin   = Carbon::parse($reservation->date_depart);
        $nbNuits   = $dateDebut->diffInDays($dateFin);

        $montantDu = $nbNuits * $reservation->chambre->prix;

        // Déjà payé = acompte + paiements
        //$totalDejaPaye = $reservation->acompte + $reservation->paiements()->sum('montant');
        $totalDejaPaye = $reservation->acompte;
        $resteAPayer   = $montantDu - $totalDejaPaye;

        // Vérification : si le paiement dépasse le reste
        if ($request->montant > $resteAPayer) {
            return back()->withErrors([
                'montant' => "Le paiement dépasse le montant restant dû (reste : $resteAPayer Ar)."
            ])->withInput();
        }

        // Vérification : acompte obligatoire
        if ($reservation->acompte > 0 && $totalDejaPaye == 0) {
            return back()->withErrors([
                'acompte' => "Cette réservation inclut un acompte de {$reservation->acompte} Ar, vous devez le régler d'abord."
            ])->withInput();
        }

        // Enregistrer le paiement
        $paiement = Paiement::create($request->all());

        // Générer une facture
        /*Facture::create([
            'paiement_id'    => $paiement->id,
            'reservation_id' => $reservation->id,
            'montant_total'  => $montantDu,
            'montant_paye'   => $totalDejaPaye + $paiement->montant,
            'reste'          => $montantDu - ($totalDejaPaye + $paiement->montant),
            'date_facture'   => now(),
        ]);
        */

        return redirect()->route('paiements.index')
                         ->with('success', 'Paiement enregistré avec succès (avance vérifiée).');
    }

    /**
     * Détails d’un paiement
     */
    public function show(Paiement $paiement)
    {
        $paiement->load('reservation.locataire', 'reservation.chambre');
        return view('paiements.show', compact('paiement'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit(Paiement $paiement)
    {
        $reservations = Reservation::with('locataire', 'chambre')->get();
        return view('paiements.edit', compact('paiement', 'reservations'));
    }

    /**
     * Mise à jour d’un paiement
     */
    public function update(Request $request, Paiement $paiement)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'montant'        => 'required|numeric|min:0',
            'mode_paiement'  => 'required|string|max:50',
            'date_paiement'  => 'required|date',
            'reference'      => 'nullable|string|max:100',
        ]);

        $paiement->update($request->all());

        return redirect()->route('paiements.index')
                         ->with('success', 'Paiement mis à jour avec succès.');
    }

    /**
     * Suppression d’un paiement
     */
    public function destroy(Paiement $paiement)
    {
        $paiement->delete();

        return redirect()->route('paiements.index')
                         ->with('success', 'Paiement supprimé avec succès.');
    }
}
