@extends('layouts.app')

@section('page-title', 'Mes Ventes')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-pro shadow-sm">
                <div class="card-header-pro d-flex justify-content-between align-items-center">
                    <span><i class="fa-solid fa-list me-2"></i>Historique des ventes</span>
                </div>
                <div class="card-body">
                    @if($sales->isEmpty())
                        <div class="text-center py-5">
                            <i class="fa-solid fa-receipt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucune vente enregistrée pour le moment.</p>
                            <a href="{{ route('reseller.dashboard') }}" class="btn btn-primary">
                                <i class="fa-solid fa-cart-plus me-2"></i>Effectuer une vente
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Référence</th>
                                        <th>Date</th>
                                        <th>Montant</th>
                                        <th>Commission</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                        <tr>
                                            <td class="fw-bold">{{ $sale->reference }}</td>
                                            <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ number_format($sale->montant_total, 0, ',', ' ') }} FCFA</td>
                                            <td class="text-success fw-bold">+ {{ number_format($sale->montant_commission, 0, ',', ' ') }} FCFA</td>
                                            <td>
                                                @if($sale->statut == 'payee')
                                                    <span class="badge bg-success">Payée</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($sale->statut) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $sales->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
