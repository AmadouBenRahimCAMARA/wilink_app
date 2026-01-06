@extends('layouts.app')

@section('content')
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-5 col-lg-4">
             <!-- Logo Brand -->
             <div class="text-center mb-3">
                 <div class="bg-white rounded-circle shadow mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-key fa-2x text-primary-custom"></i>
                 </div>
                 <h3 class="text-white mt-2 fw-bold ls-1">NOUVEAU MOT DE PASSE</h3>
                 <p class="text-white-50 small">Sécurisez votre compte</p>
            </div>

            <div class="card login-card border-0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label text-muted small text-uppercase fw-bold">Adresse Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control border-start-0 bg-light @error('email') is-invalid @enderror" 
                                       name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                                       placeholder="nom@exemple.com">
                            </div>
                            @error('email')
                                <span class="text-danger small mt-1 d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-muted small text-uppercase fw-bold">Nouveau Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                                <input id="password" type="password" class="form-control border-start-0 bg-light @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password">
                            </div>
                            @error('password')
                                <span class="text-danger small mt-1 d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                             <label for="password-confirm" class="form-label text-muted small text-uppercase fw-bold">Confirmation</label>
                             <div class="input-group">
                                 <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-check"></i></span>
                                 <input id="password-confirm" type="password" class="form-control border-start-0 bg-light" 
                                        name="password_confirmation" required autocomplete="new-password">
                             </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg shadow fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.9rem;">
                                Réinitialiser
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
