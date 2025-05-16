@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Tableau de bord</h1>
        <div>
            <span class="text-muted">Aujourd'hui: {{ date('d/m/Y') }}</span>
        </div>
    </div>

    <!-- Statistiques générales -->
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="count">{{ $totalClients }}</div>
                            <div class="title">Clients</div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('admin.clients.index') }}" class="text-primary text-decoration-none">
                        Voir détails <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="count">{{ $totalParfums }}</div>
                            <div class="title">Parfums</div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon">
                                <i class="fas fa-flask"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('admin.parfums.index') }}" class="text-primary text-decoration-none">
                        Voir détails <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="count">{{ $totalCommandes }}</div>
                            <div class="title">Commandes</div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('admin.commandes.index') }}" class="text-primary text-decoration-none">
                        Voir détails <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="count">{{ number_format($chiffreAffaires, 0, ',', ' ') }} €</div>
                            <div class="title">Chiffre d'affaires</div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon">
                                <i class="fas fa-euro-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="#" class="text-primary text-decoration-none">
                        Voir détails <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Graphique des ventes -->
        <div class="col-md-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Ventes mensuelles</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ date('Y') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#">{{ date('Y') }}</a></li>
                            <li><a class="dropdown-item" href="#">{{ date('Y') - 1 }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Commandes récentes -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Commandes récentes</h5>
                    <a href="{{ route('admin.commandes.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($commandesRecentes as $commande)
                            <a href="{{ route('admin.commandes.show', $commande->id_commande) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Commande #{{ $commande->id_commande }}</h6>
                                        <small class="text-muted">{{ $commande->client->nom }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-primary">{{ number_format($commande->total, 2, ',', ' ') }} €</span>
                                        <small class="d-block text-muted">{{ date('d/m/Y', strtotime($commande->date_commande)) }}</small>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Top parfums -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Top 5 des parfums les plus vendus</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Parfum</th>
                                    <th class="text-end">Quantité vendue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topParfums as $parfum)
                                    <tr>
                                        <td>{{ $parfum->nom }}</td>
                                        <td class="text-end">{{ $parfum->total_vendu }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('admin.parfums.create') }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-plus me-2"></i>Ajouter un parfum
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-plus me-2"></i>Ajouter une catégorie
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.commandes.index') }}" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-list me-2"></i>Gérer les commandes
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.clients.index') }}" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-users me-2"></i>Gérer les clients
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-chart-bar me-2"></i>Voir les statistiques
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-cog me-2"></i>Paramètres
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        // Données pour le graphique des ventes mensuelles
        var salesData = {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Ventes (€)',
                data: [
                    @foreach($ventesMensuelles as $vente)
                        {{ $vente->total }},
                    @endforeach
                ],
                backgroundColor: 'rgba(142, 68, 173, 0.2)',
                borderColor: 'rgba(142, 68, 173, 1)',
                borderWidth: 2,
                tension: 0.4
            }]
        };

        // Configuration du graphique
        var salesChart = new Chart(
            document.getElementById('salesChart'),
            {
                type: 'line',
                data: salesData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value + ' €';
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y + ' €';
                                }
                            }
                        }
                    }
                }
            }
        );
    });
</script>
@endsection 
