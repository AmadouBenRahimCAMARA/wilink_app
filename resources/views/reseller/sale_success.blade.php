@extends('layouts.app')

@section('page-title', 'Confirmation de Vente')

@section('content')
<div class="container text-center py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg position-relative overflow-hidden">
                <div class="position-absolute top-0 start-0 w-100 h-1 bg-success"></div>
                
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="fa-solid fa-circle-check fa-4x text-success"></i>
                    </div>

                    <h4 class="mb-2 fw-bold text-uppercase ls-1">Ticket Activé</h4>
                    <p class="text-muted mb-4">{{ $ticket->type_ticket->nom }}</p>

                    <div class="bg-light p-4 rounded-3 border border-2 border-dashed mb-4">
                        <span class="d-block text-muted small text-uppercase mb-2">Code de Connexion</span>
                        <h1 class="display-3 fw-bolder text-dark mb-0" style="font-family: monospace; letter-spacing: -2px;">
                            {{ $ticket->code }}
                        </h1>
                    </div>

                    <div class="d-flex justify-content-between text-muted small mb-4 px-4">
                        <span>Prix : <strong>{{ number_format($ticket->type_ticket->prix_public, 0, ',', ' ') }} F</strong></span>
                        <span>Réf : {{ $ticket->vente->reference ?? 'N/A' }}</span>
                    </div>

                    <div class="d-grid gap-2">
                        <button onclick="window.print()" class="btn btn-outline-dark btn-lg">
                            <i class="fa-solid fa-print me-2"></i>Imprimer le reçu
                        </button>
                        <a href="{{ route('reseller.dashboard') }}" class="btn btn-primary btn-lg mt-2">
                            <i class="fa-solid fa-cash-register me-2"></i>Nouvelle Vente
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
