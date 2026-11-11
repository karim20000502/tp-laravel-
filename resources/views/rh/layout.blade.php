<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion RH')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .stat-card .bi { font-size: 2rem; opacity: .6; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('rh.dashboard') }}"><i class="bi bi-people-fill"></i> Gestion RH</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link @if(request()->routeIs('rh.dashboard')) active @endif" href="{{ route('rh.dashboard') }}">Tableau de bord</a></li>
                <li class="nav-item"><a class="nav-link @if(request()->routeIs('rh.employes.*')) active @endif" href="{{ route('rh.employes.index') }}">Employés</a></li>
                <li class="nav-item"><a class="nav-link @if(request()->routeIs('rh.departements.*')) active @endif" href="{{ route('rh.departements.index') }}">Départements</a></li>
                <li class="nav-item"><a class="nav-link @if(request()->routeIs('rh.conges.*')) active @endif" href="{{ route('rh.conges.index') }}">Congés</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container pb-5">
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('status') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
