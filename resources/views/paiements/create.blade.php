@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Enregistrer un paiement</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('paiements.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="reservation_id" class="form-label">Réservation</label>
            <select name="reservation_id" id="reservation_id" class="form-select" required onchange="updateInfos()">
                <option value="">-- Sélectionner une réservation --</option>
                @foreach ($reservations as $reservation)
                    @php
                        $dateArrivee = \Carbon\Carbon::parse($reservation->date_arrivee);
                        $dateDepart = \Carbon\Carbon::parse($reservation->date_depart);
                        $nbNuits = $dateArrivee->diffInDays($dateDepart);
                        $montantTotal = $nbNuits * $reservation->chambre->prix;
                        $totalPaye = $reservation->acompte + $reservation->paiements->sum('montant');
                        $reste = $montantTotal - $totalPaye;
                    @endphp
                    <option
                        value="{{ $reservation->id }}"
                        data-total="{{ $montantTotal }}"
                        data-acompte="{{ $reservation->acompte }}"
                        data-paye="{{ $totalPaye }}"
                        data-reste="{{ $reste }}"
                        {{ old('reservation_id') == $reservation->id ? 'selected' : '' }}
                    >
                        #{{ $reservation->id }} - {{ $reservation->locataire->prenom }} {{ $reservation->locataire->nom }}
                        (Chambre {{ $reservation->chambre->numero }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Zone affichage infos réservation -->
        <div id="infos-reservation" class="alert alert-info d-none">
            <p><strong>Montant total :</strong> <span id="info-total"></span> Ar</p>
            <p><strong>Acompte prévu :</strong> <span id="info-acompte"></span> Ar</p>
            <p><strong>Total déjà payé :</strong> <span id="info-paye"></span> Ar</p>
            <p><strong>Reste à payer :</strong> <span id="info-reste"></span> Ar</p>
        </div>

        <div class="mb-3">
            <label for="montant" class="form-label">Montant du paiement (Ar)</label>
            <input type="number" name="montant" step="0.01" value="{{ old('montant') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="mode_paiement" class="form-label">Mode de paiement</label>
            <select name="mode_paiement" id="mode_paiement" class="form-select" required>
                <option value="espèces" {{ old('mode_paiement') == 'espèces' ? 'selected' : '' }}>Espèces</option>
                <option value="carte" {{ old('mode_paiement') == 'carte' ? 'selected' : '' }}>Carte bancaire</option>
                <option value="virement" {{ old('mode_paiement') == 'virement' ? 'selected' : '' }}>Virement</option>
                <option value="autre" {{ old('mode_paiement') == 'autre' ? 'selected' : '' }}>Autre</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="date_paiement" class="form-label">Date du paiement</label>
            <input type="date" name="date_paiement" value="{{ old('date_paiement') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="reference" class="form-label">Référence (optionnel)</label>
            <input type="text" name="reference" value="{{ old('reference') }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('paiements.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<script>
    function updateInfos() {
        let select = document.getElementById("reservation_id");
        let option = select.options[select.selectedIndex];

        if (option.value) {
            document.getElementById("infos-reservation").classList.remove("d-none");
            document.getElementById("info-total").textContent = option.getAttribute("data-total");
            document.getElementById("info-acompte").textContent = option.getAttribute("data-acompte");
            document.getElementById("info-paye").textContent = option.getAttribute("data-paye");
            document.getElementById("info-reste").textContent = option.getAttribute("data-reste");
        } else {
            document.getElementById("infos-reservation").classList.add("d-none");
        }
    }

    // Mise à jour auto si une réservation est déjà sélectionnée (old input)
    window.onload = updateInfos;
</script>
@endsection
