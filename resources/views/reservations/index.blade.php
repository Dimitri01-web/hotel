@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des réservations</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('reservations.create') }}" class="btn btn-success">Nouvelle réservation</a>
    </div>

    @if ($reservations->count() > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Locataire</th>
                    <th>Chambre</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Acompte (Ar)</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->id }}</td>
                        <td>{{ $reservation->locataire->prenom }} {{ $reservation->locataire->nom }}</td>
                        <td>Chambre {{ $reservation->chambre->numero }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->date_arrivee)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->date_depart)->format('d/m/Y') }}</td>
                        <td>{{ number_format($reservation->acompte, 2, ',', ' ') }}</td>
                        <td>
                            @if($reservation->statut == 'confirmée')
                                <span class="badge bg-success">Confirmée</span>
                            @elseif($reservation->statut == 'annulée')
                                <span class="badge bg-danger">Annulée</span>
                            @else
                                <span class="badge bg-warning">En attente</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-info">Voir</a>
                            <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-sm btn-warning">Modifier</a>
                            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette réservation ?')">
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
        <div class="alert alert-info">Aucune réservation trouvée.</div>
    @endif
</div>
@endsection
