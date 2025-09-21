@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter une chambre</h1>

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

    <form action="{{ route('chambres.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="numero" class="form-label">Numéro de chambre</label>
            <input type="text" name="numero" id="numero" value="{{ old('numero') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type de chambre</label>
            <select name="type" id="type" class="form-select" required>
                <option value="">-- Sélectionner le type --</option>
                <option value="simple" {{ old('type') === 'simple' ? 'selected' : '' }}>Simple</option>
                <option value="double" {{ old('type') === 'double' ? 'selected' : '' }}>Double</option>
                <option value="suite" {{ old('type') === 'suite' ? 'selected' : '' }}>Suite</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix par nuit (Ar)</label>
            <input type="number" name="prix" id="prix" step="0.01" value="{{ old('prix') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="etat" class="form-label">État</label>
            <select name="etat" id="etat" class="form-select" required>
                <option value="">-- Sélectionner l’état --</option>
                <option value="libre" {{ old('etat') === 'libre' ? 'selected' : '' }}>Libre</option>
                <option value="occupée" {{ old('etat') === 'occupée' ? 'selected' : '' }}>Occupée</option>
                <option value="maintenance" {{ old('etat') === 'maintenance' ? 'selected' : '' }}>En maintenance</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('chambres.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
