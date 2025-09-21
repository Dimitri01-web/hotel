@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de la réservation #{{ $reservation->id }}</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Informations de la réservation</h5>
            <p><strong>Chambre :</strong>
                @if ($reservation->chambre)
                    {{ $reservation->chambre->numero }} ({{ $reservation->chambre->type }})
                @else
                    —
                @endif
            </p>
            <p><strong>Locataire :</strong>
                @if ($reservation->locataire)
                    {{ $reservation->locataire->prenom }} {{ $reservation->locataire->nom }}
                @else
                    —
                @endif
            </p>
            <p><strong>Date d'arrivée :</strong> {{ \Carbon\Carbon::parse($reservation->date_arrivee)->format('d/m/Y') }}</p>
            <p><strong>Date de départ :</strong> {{ \Carbon\Carbon::parse($reservation->date_depart)->format('d/m/Y') }}</p>
            <p>
                <strong>Statut :</strong>
                @if ($reservation->statut === 'confirmée')
                    <span class="badge bg-success">{{ ucfirst($reservation->statut) }}</span>
                @elseif ($reservation->statut === 'en attente')
                    <span class="badge bg-warning text-dark">{{ ucfirst($reservation->statut) }}</span>
                @else
                    <span class="badge bg-secondary">{{ ucfirst($reservation->statut) }}</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Actions --}}
    <div class="mt-3">
        <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-warning">Modifier</a>
        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Voulez-vous vraiment supprimer cette réservation ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </div>
</div>
@endsection
