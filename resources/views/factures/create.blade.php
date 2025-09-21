@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nouvelle facture</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('factures.store') }}" method="POST">
        @csrf

        <!-- Sélection du paiement -->
        <div class="mb-3">
            <label for="paiement_id" class="form-label">Paiement</label>
            <select name="paiement_id" id="paiement_id" class="form-select" required onchange="updateInfos()">
                <option value="">-- Sélectionner un paiement --</option>
                @foreach ($paiements as $paiement)
                    @php
                        $reservation = $paiement->reservation;
                        $dateArrivee = \Carbon\Carbon::parse($reservation->date_arrivee);
                        $dateDepart   = \Carbon\Carbon::parse($reservation->date_depart);
                        $nbNuits   = $dateArrivee->diffInDays($dateDepart);
                        $montantTotal = $nbNuits * $reservation->chambre->prix;
                        $totalPaye = $reservation->acompte + $reservation->paiements->sum('montant');
                        $reste = $montantTotal - $totalPaye;
                    @endphp
                    <option
                        value="{{ $paiement->id }}"
                        data-reservation="{{ $reservation->id }}"
                        data-total="{{ $montantTotal }}"
                        data-paye="{{ $totalPaye }}"
                        data-reste="{{ $reste }}"
                    >
                        Paiement #{{ $paiement->id }} - Réservation #{{ $reservation->id }}
                        ({{ $reservation->locataire->prenom }} {{ $reservation->locataire->nom }} - Chambre {{ $reservation->chambre->numero }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Zone d’infos -->
        <div id="infos-facture" class="alert alert-info d-none">
            <p><strong>Montant total :</strong> <span id="info-total"></span> €</p>
            <p><strong>Total payé :</strong> <span id="info-paye"></span> €</p>
            <p><strong>Reste à payer :</strong> <span id="info-reste"></span> €</p>
        </div>

        <!-- Montants -->
        <div class="mb-3">
            <label for="montant_total" class="form-label">Montant total (€)</label>
            <input type="number" name="montant_total" id="montant_total" class="form-control" step="0.01" required readonly>
        </div>

        <div class="mb-3">
            <label for="montant_paye" class="form-label">Montant payé (€)</label>
            <input type="number" name="montant_paye" id="montant_paye" class="form-control" step="0.01" required readonly>
        </div>

        <div class="mb-3">
            <label for="reste" class="form-label">Reste à payer (€)</label>
            <input type="number" name="reste" id="reste" class="form-control" step="0.01" required readonly>
        </div>

        <!-- Date de facture -->
        <div class="mb-3">
            <label for="date_facture" class="form-label">Date de facture</label>
            <input type="date" name="date_facture" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('factures.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<script>
    function updateInfos() {
        let select = document.getElementById("paiement_id");
        let option = select.options[select.selectedIndex];

        if (option.value) {
            document.getElementById("infos-facture").classList.remove("d-none");

            let total = option.getAttribute("data-total");
            let paye  = option.getAttribute("data-paye");
            let reste = option.getAttribute("data-reste");

            document.getElementById("info-total").textContent = total;
            document.getElementById("info-paye").textContent  = paye;
            document.getElementById("info-reste").textContent = reste;

            document.getElementById("montant_total").value = total;
            document.getElementById("montant_paye").value  = paye;
            document.getElementById("reste").value         = reste;
        } else {
            document.getElementById("infos-facture").classList.add("d-none");
        }
    }
</script>
@endsection
