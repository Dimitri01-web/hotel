@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des paiements</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('paiements.create') }}" class="btn btn-success">Enregistrer un paiement</a>
    </div>

    @if ($paiements->count() > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Réservation</th>
                    <th>Locataire</th>
                    <th>Montant (Ar)</th>
                    <th>Mode</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paiements as $paiement)
                    <tr>
                        <td>{{ $paiement->id }}</td>
                        <td>#{{ $paiement->reservation->id }}</td>
                        <td>{{ $paiement->reservation->locataire->prenom }} {{ $paiement->reservation->locataire->nom }}</td>
                        <td>{{ number_format($paiement->montant, 2, ',', ' ') }}</td>
                        <td>{{ ucfirst($paiement->mode_paiement) }}</td>
                        <td>{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('paiements.show', $paiement) }}" class="btn btn-sm btn-info">Voir</a>
                            <a href="{{ route('paiements.edit', $paiement) }}" class="btn btn-sm btn-warning">Modifier</a>
                            <form action="{{ route('paiements.destroy', $paiement) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce paiement ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">Aucun paiement enregistré.</div>
    @endif
</div>
@endsection
