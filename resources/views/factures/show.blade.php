@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Facture n° {{ $facture->numero }}</h1>
        <button onclick="window.print()" class="btn btn-outline-primary">Imprimer</button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                <h5>Hôtel Demo</h5>
                <p>
                    Adresse : 123 Rue Principale<br>
                    Téléphone : +33 1 23 45 67 89<br>
                    Email : contact@hotel-demo.com
                </p>
            </div>

            <div class="mb-4">
                <h5>Informations client</h5>
                <p>
                    <strong>Nom :</strong> {{ $facture->reservation->locataire->prenom }} {{ $facture->reservation->locataire->nom }}<br>
                    <strong>Email :</strong> {{ $facture->reservation->locataire->email ?? '—' }}<br>
                    <strong>Téléphone :</strong> {{ $facture->reservation->locataire->telephone ?? '—' }}
                </p>
            </div>

            <div class="mb-4">
                <h5>Détails de la réservation</h5>
                <p>
                    <strong>Chambre :</strong> {{ $facture->reservation->chambre->numero ?? '' }} ({{ $facture->reservation->chambre->type ?? '' }})<br>
                    <strong>Date d'arrivée :</strong> {{ \Carbon\Carbon::parse($facture->reservation->date_arrivee)->format('d/m/Y') }}<br>
                    <strong>Date de départ :</strong> {{ \Carbon\Carbon::parse($facture->reservation->date_depart)->format('d/m/Y') }}<br>
                    <strong>Statut réservation :</strong> {{ ucfirst($facture->reservation->statut) }}
                </p>
            </div>

            <div class="mb-4">
                <h5>Paiement</h5>
                <p>
                    <strong>Montant payé :</strong> {{ number_format($facture->paiement->montant, 2, ',', ' ') }} €<br>
                    <strong>Mode de paiement :</strong> {{ ucfirst($facture->paiement->mode_paiement) }}<br>
                    <strong>Date du paiement :</strong> {{ \Carbon\Carbon::parse($facture->paiement->date_paiement)->format('d/m/Y') }}
                </p>
            </div>

            <hr>

            <div class="mb-4">
                <h4 class="text-end">Total : {{ number_format($facture->total, 2, ',', ' ') }} €</h4>
            </div>

            <p class="text-center text-muted">Merci pour votre confiance. À bientôt !</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('factures.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </div>
</div>
@endsection
