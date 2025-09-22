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
 <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('chambres.index') }}" class="mb-3">
        <div class="input-group">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Rechercher par type..."
                value="{{ request('search') }}"
            >
            <button class="btn btn-primary" type="submit">Rechercher</button>
        </div>
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
