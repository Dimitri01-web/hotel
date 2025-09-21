<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Chambre;
use App\Models\Locataire;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Afficher la liste des réservations.
     */
    public function index()
    {
        // Charger aussi les relations pour éviter les requêtes multiples
        $reservations = Reservation::with(['chambre', 'locataire'])->get();

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Afficher le formulaire de création d'une réservation.
     */
    public function create()
    {
        // On peut filtrer les chambres libres ici si on le souhaite
        $chambres = Chambre::all();
        $locataires = Locataire::all();

        return view('reservations.create', compact('chambres', 'locataires'));
    }

    /**
     * Enregistrer une nouvelle réservation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'chambre_id'    => 'required|exists:chambres,id',
            'locataire_id'  => 'required|exists:locataires,id',
            'date_arrivee'  => 'required|date|after_or_equal:today',
            'date_depart'   => 'required|date|after:date_arrivee',
            'statut'        => 'required|string|max:50',
        ]);

        Reservation::create($request->all());

        return redirect()->route('reservations.index')
                         ->with('success', 'Réservation créée avec succès.');
    }

    /**
     * Afficher les détails d’une réservation.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['chambre', 'locataire']);
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Afficher le formulaire d’édition d’une réservation.
     */
    public function edit(Reservation $reservation)
    {
        $chambres = Chambre::all();
        $locataires = Locataire::all();

        return view('reservations.edit', compact('reservation', 'chambres', 'locataires'));
    }

    /**
     * Mettre à jour une réservation.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'chambre_id'    => 'required|exists:chambres,id',
            'locataire_id'  => 'required|exists:locataires,id',
            'date_arrivee'  => 'required|date|after_or_equal:today',
            'date_depart'   => 'required|date|after:date_arrivee',
            'statut'        => 'required|string|max:50',
        ]);

        $reservation->update($request->all());

        return redirect()->route('reservations.index')
                         ->with('success', 'Réservation mise à jour avec succès.');
    }

    /**
     * Supprimer une réservation.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')
                         ->with('success', 'Réservation supprimée avec succès.');
    }
}
