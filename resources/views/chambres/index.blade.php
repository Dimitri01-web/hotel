@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Liste des chambres</h1>
    <a href="{{ route('chambres.create') }}" class="btn btn-primary">Ajouter une chambre</a>
</div>

@if ($chambres->isEmpty())
    <div class="alert alert-info">
        Aucune chambre enregistrée pour le moment.
    </div>
@else
<form method="GET" action="{{ route('chambres.rechercher') }}"
      class="mb-6 bg-white p-4 rounded shadow flex flex-wrap gap-4">

    <input type="text" name="numero" placeholder="Numéro de chambre"
           value="{{ request('numero') }}" class="border p-2 rounded">

    <input type="text" name="type" placeholder="Type (Simple, Double, Suite...)"
           value="{{ request('type') }}" class="border p-2 rounded">

    <input type="number" name="prix_min" placeholder="Prix minimum"
           value="{{ request('prix_min') }}" class="border p-2 rounded w-32">

    <input type="number" name="prix_max" placeholder="Prix maximum"
           value="{{ request('prix_max') }}" class="border p-2 rounded w-32">

    <select name="disponible" class="border p-2 rounded">
        <option value="">Disponibilité</option>
        <option value="1" {{ request('disponible') === '1' ? 'selected' : '' }}>Libre</option>
        <option value="0" {{ request('disponible') === '0' ? 'selected' : '' }}>Occupée</option>
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        Rechercher
    </button>
</form>


    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Numéro</th>
                <th>Type</th>
                <th>Prix</th>
                <th>État</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chambres as $chambre)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $chambre->numero }}</td>
                <td>{{ $chambre->type }}</td>
                <td>{{ number_format($chambre->prix, 2, ',', ' ') }} Ar</td>
                <td>
                    @if ($chambre->etat === 'occupée')
                        <span class="badge bg-danger">{{ ucfirst($chambre->etat) }}</span>
                    @elseif ($chambre->etat === 'libre')
                        <span class="badge bg-success">{{ ucfirst($chambre->etat) }}</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($chambre->etat) }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('chambres.show', $chambre) }}" class="btn btn-sm btn-info">Voir</a>
                    <a href="{{ route('chambres.edit', $chambre) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('chambres.destroy', $chambre) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Voulez-vous vraiment supprimer cette chambre ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
