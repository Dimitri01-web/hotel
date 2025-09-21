@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la réservation #{{ $reservation->id }}</h1>

    {{-- Affichage des erreurs de validation --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oups !</strong> Il y a des erreurs dans le formulaire.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reservations.update', $reservation) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="chambre_id" class="form-label">Chambre</label>
            <select name="chambre_id" id="chambre_id" class="form-select" required>
                <option value="">-- Sélectionner une chambre --</option>
                @foreach ($chambres as $chambre)
                    <option value="{{ $chambre->id }}"
                        {{ old('chambre_id', $reservation->chambre_id) == $chambre->id ? 'selected' : '' }}>
                        {{ $chambre->numero }} ({{ $chambre->type }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="locataire_id" class="form-label">Locataire</label>
            <select name="locataire_id" id="locataire_id" class="form-select" required>
                <option value="">-- Sélectionner un locataire --</option>
                @foreach ($locataires as $locataire)
                    <option value="{{ $locataire->id }}"
                        {{ old('locataire_id', $reservation->locataire_id) == $locataire->id ? 'selected' : '' }}>
                        {{ $locataire->prenom }} {{ $locataire->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date_arrivee" class="form-label">Date d'arrivée</label>
            <input type="date" name="date_arrivee" id="date_arrivee"
                   value="{{ old('date_arrivee', $reservation->date_arrivee) }}"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date_depart" class="form-label">Date de départ</label>
            <input type="date" name="date_depart" id="date_depart"
                   value="{{ old('date_depart', $reservation->date_depart) }}"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select name="statut" id="statut" class="form-select" required>
                <option value="en attente" {{ old('statut', $reservation->statut) === 'en attente' ? 'selected' : '' }}>En attente</option>
                <option value="confirmée" {{ old('statut', $reservation->statut) === 'confirmée' ? 'selected' : '' }}>Confirmée</option>
                <option value="annulée" {{ old('statut', $reservation->statut) === 'annulée' ? 'selected' : '' }}>Annulée</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
