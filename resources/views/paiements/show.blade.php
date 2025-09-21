@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du paiement #{{ $paiement->id }}</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Réservation :</strong> #{{ $paiement->reservation->id }}</p>
            <p><strong>Locataire :</strong> {{ $paiement->reservation->locataire->prenom }} {{ $paiement->reservation->locataire->nom }}</p>
            <p><strong>Chambre :</strong> {{ $paiement->reservation->chambre->numero }}</p>
            <p><strong>Montant :</strong> {{ number_format($paiement->montant, 2, ',', ' ') }} €</p>
            <p><strong>Mode de paiement :</strong> {{ ucfirst($paiement->mode_paiement) }}</p>
            <p><strong>Date du paiement :</strong> {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</p>
            <p><strong>Référence :</strong> {{ $paiement->reference ?? '—' }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('paiements.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </div>
</div>
@endsection
