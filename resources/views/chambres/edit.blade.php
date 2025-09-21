@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la chambre : {{ $chambre->numero }}</h1>

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

    <form action="{{ route('chambres.update', $chambre) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="numero" class="form-label">Numéro de chambre</label>
            <input type="text" name="numero" id="numero" value="{{ old('numero', $chambre->numero) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type de chambre</label>
            <input type="text" name="type" id="type" value="{{ old('type', $chambre->type) }}" class="form-control" required>
            {{-- Exemple : Simple, Double, Suite --}}
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix par nuit (Ar)</label>
            <input type="number" name="prix" id="prix" step="0.01" value="{{ old('prix', $chambre->prix) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="etat" class="form-label">État</label>
            <select name="etat" id="etat" class="form-select" required>
                <option value="">-- Sélectionner l’état --</option>
                <option value="libre" {{ old('etat', $chambre->etat) === 'libre' ? 'selected' : '' }}>Libre</option>
                <option value="occupée" {{ old('etat', $chambre->etat) === 'occupée' ? 'selected' : '' }}>Occupée</option>
                <option value="maintenance" {{ old('etat', $chambre->etat) === 'maintenance' ? 'selected' : '' }}>En maintenance</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('chambres.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
