<?php

namespace App\Http\Controllers;

use App\Models\Chambre;
use Illuminate\Http\Request;

class ChambreController extends Controller
{
    /**
     * Afficher la liste des chambres.
     */
    public function index()
    {
        $chambres = Chambre::all();
        return view('chambres.index', compact('chambres'));
    }

    /**
     * Afficher le formulaire de création d’une chambre.
     */
    public function create()
    {
        return view('chambres.create');
    }

    /**
     * Enregistrer une nouvelle chambre.
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|string|max:50|unique:chambres,numero',
            'type'   => 'required|string|max:50',
            'prix'   => 'required|numeric|min:0',
            'etat'   => 'required|string|max:50',
        ]);

        Chambre::create($request->all());

        return redirect()->route('chambres.index')
                         ->with('success', 'Chambre créée avec succès.');
    }

    /**
     * Afficher les détails d’une chambre spécifique.
     */
    public function show(Chambre $chambre)
    {
        return view('chambres.show', compact('chambre'));
    }

    /**
     * Afficher le formulaire d’édition d’une chambre.
     */
    public function edit(Chambre $chambre)
    {
        return view('chambres.edit', compact('chambre'));
    }

    /**
     * Mettre à jour une chambre.
     */
    public function update(Request $request, Chambre $chambre)
    {
        $request->validate([
            'numero' => 'required|string|max:50|unique:chambres,numero,' . $chambre->id,
            'type'   => 'required|string|max:50',
            'prix'   => 'required|numeric|min:0',
            'etat'   => 'required|string|max:50',
        ]);

        $chambre->update($request->all());

        return redirect()->route('chambres.index')
                         ->with('success', 'Chambre mise à jour avec succès.');
    }

    /**
     * Supprimer une chambre.
     */
    public function destroy(Chambre $chambre)
    {
        $chambre->delete();

        return redirect()->route('chambres.index')
                         ->with('success', 'Chambre supprimée avec succès.');
    }

    public function rechercher(Request $request)
{
    $requete = Chambre::query();

    if ($request->filled('numero')) {
        $requete->where('numero', 'like', '%' . $request->numero . '%');
    }

    if ($request->filled('type')) {
        $requete->where('type', 'like', '%' . $request->type . '%');
    }

    if ($request->filled('prix_min')) {
        $requete->where('prix', '>=', $request->prix_min);
    }

    if ($request->filled('prix_max')) {
        $requete->where('prix', '<=', $request->prix_max);
    }

    if ($request->filled('disponible')) {
        $requete->where('disponible', $request->disponible);
    }

    $chambres = $requete->paginate(10);

    return view('chambres.index', compact('chambres'));
}

}
