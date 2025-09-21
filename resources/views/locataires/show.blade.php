@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du locataire : {{ $locataire->prenom }} {{ $locataire->nom }}</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Informations personnelles</h5>
            <p><strong>Nom :</strong> {{ $locataire->nom }}</p>
            <p><strong>Prénom :</strong> {{ $locataire->prenom }}</p>
            <p><strong>Email :</strong> {{ $locataire->email ?? '—' }}</p>
            <p><strong>Téléphone :</strong> {{ $locataire->telephone ?? '—' }}</p>
            <p><strong>Adresse :</strong> {{ $locataire->adresse ?? '—' }}</p>
        </div>
    </div>

    {{-- Historique des réservations --}}
    <h2>Historique des réservations</h2>
    @if ($locataire->reservations->count() > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Chambre</th>
                    <th>Date arrivée</th>
                    <th>Date départ</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($locataire->reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->chambre ? $reservation->chambre->numero : '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->date_arrivee)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->date_depart)->format('d/m/Y') }}</td>
                        <td>
                            @if ($reservation->statut === 'confirmée')
                                <span class="badge bg-success">{{ ucfirst($reservation->statut) }}</span>
                            @elseif ($reservation->statut === 'en attente')
                                <span class="badge bg-warning text-dark">{{ ucfirst($reservation->statut) }}</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($reservation->statut) }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            Aucune réservation enregistrée pour ce locataire.
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('locataires.edit', $locataire) }}" class="btn btn-warning">Modifier</a>
        <a href="{{ route('locataires.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </div>
</div>
@endsection
