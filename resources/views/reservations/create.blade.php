@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nouvelle réservation</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf

        <!-- Sélection du locataire -->
        <div class="mb-3">
            <label for="locataire_id" class="form-label">Locataire</label>
            <select name="locataire_id" id="locataire_id" class="form-select" required>
                <option value="">-- Sélectionner un locataire --</option>
                @foreach ($locataires as $locataire)
                    <option value="{{ $locataire->id }}" {{ old('locataire_id') == $locataire->id ? 'selected' : '' }}>
                        {{ $locataire->prenom }} {{ $locataire->nom }} ({{ $locataire->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Sélection de la chambre -->
        <div class="mb-3">
            <label for="chambre_id" class="form-label">Chambre</label>
            <select name="chambre_id" id="chambre_id" class="form-select" required>
                <option value="">-- Sélectionner une chambre --</option>
                @foreach ($chambres as $chambre)
                    <option value="{{ $chambre->id }}" {{ old('chambre_id') == $chambre->id ? 'selected' : '' }}>
                        Chambre {{ $chambre->numero }} - {{ $chambre->type }} ({{ number_format($chambre->prix, 2, ',', ' ') }} Ar/nuit)
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Dates -->
        <div class="mb-3">
            <label for="date_arrivee" class="form-label">Date Arrivée</label>
            <input type="date" name="date_arrivee" id="date_arrivee" class="form-control" value="{{ old('date_arrivee') }}" required>
        </div>

        <div class="mb-3">
            <label for="date_depart" class="form-label">Date de départ</label>
            <input type="date" name="date_depart" id="date_depart" class="form-control" value="{{ old('date_depart') }}" required>
        </div>

        <!-- Acompte -->
        <div class="mb-3">
            <label for="acompte" class="form-label">Acompte (Ar)</label>
            <input type="number" name="acompte" id="acompte" class="form-control" step="0.01" value="{{ old('acompte', 0) }}">
        </div>

        <!-- Statut -->
        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select name="statut" id="statut" class="form-select" required>
                <option value="en attente" {{ old('statut') == 'en attente' ? 'selected' : '' }}>En attente</option>
                <option value="confirmée" {{ old('statut') == 'confirmée' ? 'selected' : '' }}>Confirmée</option>
                <option value="annulée" {{ old('statut') == 'annulée' ? 'selected' : '' }}>Annulée</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
