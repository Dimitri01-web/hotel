<?php

namespace App\Http\Controllers;

use App\Models\Locataire;
use Illuminate\Http\Request;

class LocataireController extends Controller
{
    /**
     * Afficher la liste des locataires.
     */
    //public function index()
    //{
    //    $locataires = Locataire::all();
    //    return view('locataires.index', compact('locataires'));
    //}


    public function index(Request $request)
    {
        $query = Locataire::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nom', 'like', "%{$search}%")
            ->orWhere('prenom', 'like', "%{$search}%")
            ->orWhere('telephone', 'like', "%{$search}%");
        }

        $locataires = $query->paginate(10);

        return view('locataires.index', compact('locataires'));
    }

    /**
     * Afficher le formulaire de création d’un locataire.
     */
    public function create()
    {
        return view('locataires.create');
    }

    /**
     * Enregistrer un nouveau locataire.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom'       => 'required|string|max:100',
            'prenom'    => 'required|string|max:100',
            'email'     => 'nullable|email|max:150|unique:locataires,email',
            'telephone' => 'nullable|string|max:50',
            'adresse'   => 'nullable|string|max:255',
        ]);

        Locataire::create($request->all());

        return redirect()->route('locataires.index')
                         ->with('success', 'Locataire ajouté avec succès.');
    }

    /**
     * Afficher les détails d’un locataire.
     */
    public function show(Locataire $locataire)
    {
        $locataire->load('reservations.chambre'); // pour afficher l’historique avec les chambres
        return view('locataires.show', compact('locataire'));
    }

    /**
     * Afficher le formulaire de modification d’un locataire.
     */
    public function edit(Locataire $locataire)
    {
        return view('locataires.edit', compact('locataire'));
    }

    /**
     * Mettre à jour un locataire.
     */
    public function update(Request $request, Locataire $locataire)
    {
        $request->validate([
            'nom'       => 'required|string|max:100',
            'prenom'    => 'required|string|max:100',
            'email'     => 'nullable|email|max:150|unique:locataires,email,' . $locataire->id,
            'telephone' => 'nullable|string|max:50',
            'adresse'   => 'nullable|string|max:255',
        ]);

        $locataire->update($request->all());

        return redirect()->route('locataires.index')
                         ->with('success', 'Locataire mis à jour avec succès.');
    }

    /**
     * Supprimer un locataire.
     */
    public function destroy(Locataire $locataire)
    {
        $locataire->delete();

        return redirect()->route('locataires.index')
                         ->with('success', 'Locataire supprimé avec succès.');
    }

    public function rechercher(Request $request)
{
    $requete = Locataire::query();

    if ($request->filled('nom')) {
        $requete->where('nom', 'like', '%' . $request->nom . '%');
    }

    if ($request->filled('prenom')) {
        $requete->where('prenom', 'like', '%' . $request->prenom . '%');
    }

    if ($request->filled('email')) {
        $requete->where('email', 'like', '%' . $request->email . '%');
    }

    if ($request->filled('telephone')) {
        $requete->where('telephone', 'like', '%' . $request->telephone . '%');
    }

    $locataires = $requete->paginate(10);

    return view('locataires.index', compact('locataires'));
}

}
