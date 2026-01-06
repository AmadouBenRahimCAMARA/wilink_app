@extends('layouts.app')

@section('content')
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-5 col-lg-4">
            <!-- Logo Brand -->
            <div class="text-center mb-3">
                 <div class="bg-white rounded-circle shadow mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-lock fa-2x text-primary-custom"></i>
                 </div>
                 <h3 class="text-white mt-2 fw-bold ls-1">MOT DE PASSE</h3>
                 <p class="text-white-50 small">Récupération de compte</p>
            </div>

            <div class="card login-card border-0">
                <div class="card-body p-4">
                    <h4 class="card-title text-center mb-3 fw-bold text-dark">Réinitialisation</h4>

                    @if (session('status'))
                        <div class="alert alert-success small" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label text-muted small text-uppercase fw-bold">Adresse Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control border-start-0 bg-light @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                       placeholder="nom@exemple.com">
                            </div>
                            @error('email')
                                <span class="text-danger small mt-1 d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg shadow fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.9rem;">
                                Envoyer le lien
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-muted small text-decoration-none">
                                <i class="fa-solid fa-arrow-left me-1"></i> Retour à la connexion
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
