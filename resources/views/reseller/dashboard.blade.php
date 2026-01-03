@extends('layouts.app')

@section('page-title', 'Point de Vente')

@section('content')
<div class="container-fluid">
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">{{ session('error') }}</div>
    @endif

    <div class="row">
        <!-- Carte Solde -->
        <div class="col-md-12 mb-5">
            <div class="card card-pro bg-dark text-white" style="background: linear-gradient(135deg, #343a40 0%, #1a1e21 100%);">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 text-uppercase mb-1">Solde à verser</h6>
                        <h1 class="mb-0 fw-bold">{{ Auth::user()->revendeur ? number_format(Auth::user()->revendeur->solde_actuel, 0, ',', ' ') : 0 }} <small class="fs-5">FCFA</small></h1>
                    </div>
                    <div class="text-end">
                        <i class="fa-solid fa-wallet fa-3x text-secondary"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mb-3">
            <h5 class="text-muted fw-bold text-uppercase ls-1">Tickets Disponibles</h5>
        </div>
        
        @foreach($types as $type)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card card-pro h-100 text-center position-relative border-0 shadow-lg">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="mb-3">
                        <span class="badge bg-light text-dark fs-6">{{ $type->duree_minutes }} Minutes</span>
                    </div>
                    
                    <h3 class="card-title fw-bold mb-0 text-primary-custom">{{ $type->nom }}</h3>
                    <h2 class="my-3 text-dark fw-bolder">{{ number_format($type->prix_public, 0, ',', ' ') }} <small class="fs-6 text-muted">FCFA</small></h2>

                    <div class="mt-auto">
                        <hr class="opacity-10">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted small">Stock</span>
                            <span class="fw-bold {{ $type->stock_perso > 0 ? 'text-success' : 'text-danger' }}">
                                {{ $type->stock_perso }}
                            </span>
                        </div>

                        <form action="{{ route('reseller.sell') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type_ticket_id" value="{{ $type->id }}">
                            <button type="submit" class="btn btn-lg w-100 btn-primary shadow-sm" {{ $type->stock_perso == 0 ? 'disabled' : '' }}>
                                <i class="fa-solid fa-cart-shopping me-2"></i>VENDRE
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
