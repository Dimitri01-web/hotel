@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le paiement #{{ $paiement->id }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('paiements.update', $paiement) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="reservation_id" class="form-label">Réservation</label>
            <select name="reservation_id" id="reservation_id" class="form-select" required>
                @foreach ($reservations as $reservation)
                    <option value="{{ $reservation->id }}"
                        {{ old('reservation_id', $paiement->reservation_id) == $reservation->id ? 'selected' : '' }}>
                        #{{ $reservation->id }} - {{ $reservation->locataire->prenom }} {{ $reservation->locataire->nom }}
                        (Chambre {{ $reservation->chambre->numero }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="montant" class="form-label">Montant (€)</label>
            <input type="number" step="0.01" name="montant" value="{{ old('montant', $paiement->montant) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="mode_paiement" class="form-label">Mode de paiement</label>
            <select name="mode_paiement" id="mode_paiement" class="form-select" required>
                <option value="espèces" {{ old('mode_paiement', $paiement->mode_paiement) == 'espèces' ? 'selected' : '' }}>Espèces</option>
                <option value="carte" {{ old('mode_paiement', $paiement->mode_paiement) == 'carte' ? 'selected' : '' }}>Carte bancaire</option>
                <option value="virement" {{ old('mode_paiement', $paiement->mode_paiement) == 'virement' ? 'selected' : '' }}>Virement</option>
                <option value="autre" {{ old('mode_paiement', $paiement->mode_paiement) == 'autre' ? 'selected' : '' }}>Autre</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="date_paiement" class="form-label">Date du paiement</label>
            <input type="date" name="date_paiement" value="{{ old('date_paiement', $paiement->date_paiement) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="reference" class="form-label">Référence</label>
            <input type="text" name="reference" value="{{ old('reference', $paiement->reference) }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('paiements.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
