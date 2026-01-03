@extends('layouts.app')

@section('content')
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-5 col-lg-5">
            <!-- Logo Brand -->
            <div class="text-center mb-4 text-white">
                 <h2 class="fw-bold ls-1">Devenir Revendeur</h2>
                 <p class="text-white-50 small">Rejoignez le réseau Wilink International</p>
            </div>

            <!-- Register Card -->
            <div class="card login-card border-0">
                <div class="card-body p-4">
                    <h4 class="card-title text-center mb-3 fw-bold text-dark">Inscription</h4>
                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label text-muted small text-uppercase fw-bold">Nom Complet</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-user"></i></span>
                                <input id="name" type="text" class="form-control border-start-0 bg-light @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                       placeholder="Votre Nom">
                            </div>
                            @error('name')
                                <span class="text-danger small mt-1 d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-muted small text-uppercase fw-bold">Adresse Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control border-start-0 bg-light @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email"
                                       placeholder="nom@exemple.com">
                            </div>
                            @error('email')
                                <span class="text-danger small mt-1 d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label text-muted small text-uppercase fw-bold">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                                    <input id="password" type="password" class="form-control border-start-0 bg-light @error('password') is-invalid @enderror" 
                                           name="password" required autocomplete="new-password">
                                </div>
                                @error('password')
                                    <span class="text-danger small mt-1 d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password-confirm" class="form-label text-muted small text-uppercase fw-bold">Confirmation</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-check"></i></span>
                                    <input id="password-confirm" type="password" class="form-control border-start-0 bg-light" 
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-success btn-lg shadow fw-bold text-uppercase" style="letter-spacing: 1px;">
                                S'inscrire maintenant
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-white text-center py-3 border-0">
                    <p class="mb-0 text-muted small">Déjà un compte ? <a href="{{ route('login') }}" class="fw-bold text-primary-custom text-decoration-none">Se connecter</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
