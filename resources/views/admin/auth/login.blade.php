<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion — Girona de Saly Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}?v=2" rel="stylesheet">
</head>
<body class="admin-app admin-login-page">
<div class="admin-login-wrap">
    <div class="admin-login-card">
        <div class="text-center mb-4">
            <img src="{{ asset('images/girona-logo.png') }}" alt="Girona de Saly" class="admin-login-logo">
            <h1 class="admin-login-title">Espace administration</h1>
            <p class="text-muted mb-0">Girona de Saly · Académie</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger border-0">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="admin-form">
            @csrf
            <div class="mb-3">
                <label class="form-label">Adresse e-mail</label>
                <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control form-control-lg" required autocomplete="current-password">
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Rester connecté</label>
            </div>
            <button type="submit" class="btn btn-girona btn-lg w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
            </button>
        </form>
    </div>
</div>
</body>
</html>
