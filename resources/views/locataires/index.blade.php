@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Liste des locataires</h1>
    <a href="{{ route('locataires.create') }}" class="btn btn-primary">Ajouter un locataire</a>
</div>

@if ($locataires->isEmpty())
    <div class="alert alert-info">
        Aucun locataire enregistré pour le moment.
    </div>
@else
<!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('locataires.index') }}" class="mb-3">
        <div class="input-group">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Rechercher par nom, prénom, téléphone..."
                value="{{ request('search') }}"
            >
            <button class="btn btn-primary" type="submit">Rechercher</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($locataires as $locataire)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $locataire->nom }}</td>
                <td>{{ $locataire->prenom }}</td>
                <td>{{ $locataire->email ?? '—' }}</td>
                <td>{{ $locataire->telephone ?? '—' }}</td>
                <td>
                    <a href="{{ route('locataires.show', $locataire) }}" class="btn btn-sm btn-info">Voir</a>
                    <a href="{{ route('locataires.edit', $locataire) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('locataires.destroy', $locataire) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Voulez-vous vraiment supprimer ce locataire ?');">
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
