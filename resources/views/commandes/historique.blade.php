@extends('layouts.app')

@section('title', 'Historique des commandes')

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.profile') }}">Mon profil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Historique des commandes</li>
            </ol>
        </nav>

        <h1 class="mb-4">Historique de vos commandes</h1>

        @if($commandes->count() > 0)
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>N° Commande</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Total</th>
                                    <th>Livraison</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commandes as $commande)
                                    <tr>
                                        <td>#{{ $commande->id_commande }}</td>
                                        <td>{{ date('d/m/Y', strtotime($commande->date_commande)) }}</td>
                                        <td>
                                            @if($commande->statut == 'en attente')
                                                <span class="badge bg-warning text-dark">En attente</span>
                                            @elseif($commande->statut == 'confirmée')
                                                <span class="badge bg-info">Confirmée</span>
                                            @elseif($commande->statut == 'expédiée')
                                                <span class="badge bg-primary">Expédiée</span>
                                            @elseif($commande->statut == 'livrée')
                                                <span class="badge bg-success">Livrée</span>
                                            @elseif($commande->statut == 'annulée')
                                                <span class="badge bg-danger">Annulée</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($commande->total, 2, ',', ' ') }} €</td>
                                        <td>
                                            @if($commande->livraison)
                                                @if($commande->livraison->statut == 'en préparation')
                                                    <span class="badge bg-warning text-dark">En préparation</span>
                                                @elseif($commande->livraison->statut == 'en transit')
                                                    <span class="badge bg-info">En transit</span>
                                                @elseif($commande->livraison->statut == 'livrée')
                                                    <span class="badge bg-success">Livrée</span>
                                                @elseif($commande->livraison->statut == 'échouée')
                                                    <span class="badge bg-danger">Échouée</span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">Non disponible</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('commandes.detail', $commande->id_commande) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Détails
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $commandes->links() }}
            </div>
        @else
            <div class="alert alert-info">
                <p class="mb-0">Vous n'avez pas encore passé de commande.</p>
            </div>
            <a href="{{ route('parfums.index') }}" class="btn btn-primary">
                <i class="fas fa-shopping-bag me-2"></i>Découvrir nos parfums
            </a>
        @endif
    </div>
@endsection