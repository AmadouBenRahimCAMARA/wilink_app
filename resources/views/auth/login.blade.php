@extends('layouts.app')

@section('content')
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-5 col-lg-4">
            <!-- Logo Brand -->
            <div class="text-center mb-3">
                 <div class="bg-white rounded-circle shadow mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-wifi fa-2x text-primary-custom"></i>
                 </div>
                 <h3 class="text-white mt-2 fw-bold ls-1">WILINK APP</h3>
                 <p class="text-white-50 small">Gestion WiFi Professionnelle</p>
            </div>

            <!-- Login Card -->
            <div class="card login-card border-0">
                <div class="card-body p-4">
                    <h4 class="card-title text-center mb-3 fw-bold text-dark">Connexion</h4>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label text-muted small text-uppercase fw-bold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control border-start-0 bg-light @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                       placeholder="nom@exemple.com">
                            </div>
                            @error('email')
                                <span class="text-danger small mt-1 d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-muted small text-uppercase fw-bold">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                                <input id="password" type="password" class="form-control border-start-0 bg-light @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="current-password" placeholder="••••••••">
                            </div>
                            @error('password')
                                <span class="text-danger small mt-1 d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small text-muted" for="remember">
                                    Se souvenir de moi
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small text-primary-custom fw-bold" href="{{ route('password.request') }}">
                                    Oublié ?
                                </a>
                            @endif
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg shadow fw-bold text-uppercase" style="letter-spacing: 1px;">
                                Se connecter
                            </button>
                        </div>

                        <div class="text-center">
                            <span class="text-muted small">Nouveau ici ?</span>
                            <a href="{{ route('register') }}" class="fw-bold text-success text-decoration-none">Créer un compte Revendeur</a>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
