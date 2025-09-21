<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système de gestion hôtelier</title>
    {{-- Si tu utilises Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    {{-- Barre de navigation --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Hôtel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('chambres.index') }}">Chambres</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('locataires.index') }}">Locataires</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reservations.index') }}">Réservations</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('paiements.index') }}">Paiements</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('factures.index') }}">Factures</a></li>


                    {{-- Si tu gères aussi les paiements/factures : --}}
                    {{-- <li class="nav-item"><a class="nav-link" href="{{ route('paiements.index') }}">Paiements</a></li> --}}
                    {{-- <li class="nav-item"><a class="nav-link" href="{{ route('factures.index') }}">Factures</a></li> --}}
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        {{-- Messages flash global --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Contenu spécifique à chaque page --}}
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-light text-center mt-4 py-3">
        <small>&copy; {{ date('Y') }} Mon Hôtel — Système de gestion</small>
    </footer>

    {{-- Si tu utilises Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
