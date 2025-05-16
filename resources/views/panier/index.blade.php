@extends('layouts.app')

@section('title', 'Panier')

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Panier</li>
            </ol>
        </nav>

        <h1 class="mb-4">Votre panier</h1>

        @if($panierItems->count() > 0)
            <form action="{{ route('panier.mettreAJour') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Articles ({{ $panierItems->count() }})</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Produit</th>
                                                <th>Prix</th>
                                                <th>Quantité</th>
                                                <th>Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($panierItems as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if($item->parfum->image)
                                                                <img src="{{ asset('storage/' . $item->parfum->image) }}" alt="{{ $item->parfum->nom }}" class="img-thumbnail me-3" style="width: 60px;">
                                                            @else
                                                                <img src="https://via.placeholder.com/60x60?text=Parfum" alt="{{ $item->parfum->nom }}" class="img-thumbnail me-3" style="width: 60px;">
                                                            @endif
                                                            <div>
                                                                <h6 class="mb-0">{{ $item->parfum->nom }}</h6>
                                                                <small class="text-muted">{{ $item->parfum->categorie->nom }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ number_format($item->parfum->prix, 2, ',', ' ') }} €</td>
                                                    <td>
                                                        <input type="number" name="quantite[{{ $item->parfum->id_parfum }}]" class="form-control form-control-sm" value="{{ $item->quantite }}" min="1" max="{{ $item->parfum->stock }}" style="width: 70px;">
                                                    </td>
                                                    <td>{{ number_format($item->parfum->prix * $item->quantite, 2, ',', ' ') }} €</td>
                                                    <td>
                                                        <form action="{{ route('panier.supprimer') }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="id_parfum" value="{{ $item->parfum->id_parfum }}">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('parfums.index') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-arrow-left me-2"></i>Continuer les achats
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-sync-alt me-2"></i>Mettre à jour le panier
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Récapitulatif</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Sous-total</span>
                                    <span>{{ number_format($total, 2, ',', ' ') }} €</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Livraison</span>
                                    <span>Gratuite</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total</strong>
                                    <strong>{{ number_format($total, 2, ',', ' ') }} €</strong>
                                </div>
                                <div class="d-grid gap-2">
                                    @if(Auth::guard('client')->check())
                                        <a href="{{ route('commandes.checkout') }}" class="btn btn-success">
                                            <i class="fas fa-lock me-2"></i>Procéder au paiement
                                        </a>
                                    @else
                                        <a href="{{ route('client.login') }}" class="btn btn-primary">
                                            <i class="fas fa-sign-in-alt me-2"></i>Connectez-vous pour commander
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Code promo</h5>
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Entrez votre code">
                                    <button class="btn btn-outline-primary" type="button">Appliquer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <div class="alert alert-info">
                <p class="mb-0">Votre panier est vide.</p>
            </div>
            <a href="{{ route('parfums.index') }}" class="btn btn-primary">
                <i class="fas fa-shopping-bag me-2"></i>Découvrir nos parfums
            </a>
        @endif
    </div>
@endsection