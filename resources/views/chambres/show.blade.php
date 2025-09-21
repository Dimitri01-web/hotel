@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de la chambre : {{ $chambre->numero }}</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Informations</h5>
            <p><strong>Numéro :</strong> {{ $chambre->numero }}</p>
            <p><strong>Type :</strong> {{ $chambre->type }}</p>
            <p><strong>Prix par nuit :</strong> {{ number_format($chambre->prix, 2, ',', ' ') }} Ar</p>
            <p>
                <strong>État :</strong>
                @if ($chambre->etat === 'occupée')
                    <span class="badge bg-danger">{{ ucfirst($chambre->etat) }}</span>
                @elseif ($chambre->etat === 'libre')
                    <span class="badge bg-success">{{ ucfirst($chambre->etat) }}</span>
                @else
                    <span class="badge bg-secondary">{{ ucfirst($chambre->etat) }}</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Historique des réservations de cette chambre (optionnel) --}}
    @if (isset($chambre->reservations) && $chambre->reservations->count() > 0)
        <h2>Historique des réservations</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Locataire</th>
                    <th>Date arrivée</th>
                    <th>Date départ</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chambre->reservations as $reservation)
                    <tr>
                        <td>
                            @if ($reservation->locataire)
                                {{ $reservation->locataire->prenom }} {{ $reservation->locataire->nom }}
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($reservation->date_arrivee)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->date_depart)->format('d/m/Y') }}</td>
                        <td>{{ ucfirst($reservation->statut) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            Aucune réservation enregistrée pour cette chambre.
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('chambres.edit', $chambre) }}" class="btn btn-warning">Modifier</a>
        <a href="{{ route('chambres.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </div>
</div>
@endsection
