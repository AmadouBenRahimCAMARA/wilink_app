@extends('layouts.app')

@section('page-title', 'Gestion des Revendeurs')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-pro">
                <div class="card-header-pro d-flex justify-content-between align-items-center">
                    <span><i class="fa-solid fa-users me-2"></i>Liste des Revendeurs</span>
                    <a href="#" class="btn btn-sm btn-primary disabled">
                        <i class="fa-solid fa-plus me-1"></i> Nouveau Revendeur
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Nom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Ville/Adresse</th>
                                    <th>Solde (Dette)</th>
                                    <th>Inscrit le</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($revendeurs as $user)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                {{ $user->name }}
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->revendeur->telephone ?? 'N/A' }}</td>
                                        <td>{{ $user->revendeur->adresse ?? 'N/A' }}</td>
                                        <td>
                                            @if(($user->revendeur->solde_actuel ?? 0) > 0)
                                                <span class="badge bg-danger">Dette: {{ number_format($user->revendeur->solde_actuel, 0, ',', ' ') }} F</span>
                                            @else
                                                <span class="badge bg-success">À jour</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary" title="Détails">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success" title="Encaisser" disabled>
                                                    <i class="fa-solid fa-money-bill-wave"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-user-slash fa-2x mb-3 d-block"></i>
                                            Aucun revendeur inscrit pour le moment.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    {{ $revendeurs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
