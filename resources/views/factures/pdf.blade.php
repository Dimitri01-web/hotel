<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $facture->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table, .table th, .table td { border: 1px solid #000; }
        .table th, .table td { padding: 8px; text-align: left; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Facture #{{ $facture->id }}</h2>
        <p>Date : {{ \Carbon\Carbon::parse($facture->date_facture)->format('d/m/Y') }}</p>
    </div>

    <p><strong>Client :</strong> {{ $facture->reservation->locataire->prenom }} {{ $facture->reservation->locataire->nom }}</p>
    <p><strong>Email :</strong> {{ $facture->reservation->locataire->email }}</p>

    <p><strong>Chambre :</strong> {{ $facture->reservation->chambre->numero }} ({{ $facture->reservation->chambre->type }})</p>
    <p><strong>Période :</strong>
        {{ \Carbon\Carbon::parse($facture->reservation->date_debut)->format('d/m/Y') }}
        au
        {{ \Carbon\Carbon::parse($facture->reservation->date_fin)->format('d/m/Y') }}
    </p>

    <table class="table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Montant (€)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Séjour ({{ $facture->reservation->chambre->prix_par_nuit }} €/nuit)</td>
                <td>{{ number_format($facture->montant_total, 2, ',', ' ') }}</td>
            </tr>
            <tr>
                <td>Total payé</td>
                <td>{{ number_format($facture->montant_paye, 2, ',', ' ') }}</td>
            </tr>
            <tr class="total">
                <td>Reste à payer</td>
                <td>{{ number_format($facture->reste, 2, ',', ' ') }}</td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top:30px;">Merci pour votre confiance.</p>
</body>
</html>
