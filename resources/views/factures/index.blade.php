@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des factures</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('factures.create') }}" class="btn btn-success">Nouvelle facture</a>
    </div>

    @if ($factures->count() > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Réservation</th>
                    <th>Locataire</th>
                    <th>Chambre</th>
                    <th>Total (Ar)</th>
                    <th>Payé (Ar)</th>
                    <th>Reste (Ar)</th>
                    <th>Date facture</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($factures as $facture)
                    <tr>
                        <td>{{ $facture->id }}</td>
                        <td>#{{ $facture->reservation_id }}</td>
                        <td>{{ $facture->paiement->reservation->locataire->prenom }} {{ $facture->paiement->reservation->locataire->nom }}</td>
                        <td>Chambre {{ $facture->paiement->reservation->chambre->numero }}</td>
                        <td>{{ number_format($facture->montant_total, 2, ',', ' ') }}</td>
                        <td>{{ number_format($facture->montant_paye, 2, ',', ' ') }}</td>
                        <td>{{ number_format($facture->reste, 2, ',', ' ') }}</td>
                        <td>{{ \Carbon\Carbon::parse($facture->date_facture)->format('d/m/Y') }}</td>
                        <td>
                            @if($facture->reste <= 0)
                                <span class="badge bg-success">Payée</span>
                            @else
                                <span class="badge bg-warning">Partielle</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('factures.show', $facture) }}" class="btn btn-sm btn-info">Voir</a>
                            <a href="" class="btn btn-sm btn-warning">Modifier</a>
                            <form action="" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette facture ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                            <a href="{{ route('factures.pdf', $facture) }}" class="btn btn-sm btn-dark">PDF</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">Aucune facture trouvée.</div>
    @endif
</div>
@endsection
