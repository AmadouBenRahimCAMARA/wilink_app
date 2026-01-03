@extends('layouts.app')

@section('page-title', 'Rapports & Statistiques')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center py-5">
            <div class="card card-pro p-5">
                <div class="mb-4">
                    <i class="fa-solid fa-chart-pie fa-4x text-muted opacity-50"></i>
                </div>
                <h3 class="fw-bold text-dark">Module en construction</h3>
                <p class="text-muted">Les rapports détaillés des ventes et des commissions seront disponibles bientôt.</p>
                <div class="mt-4">
                    <a href="{{ route('admin.tickets.index') }}" class="btn btn-primary">Retour au Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
