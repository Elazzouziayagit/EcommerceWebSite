@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4">Découvrez notre collection de parfums</h1>
            <p class="lead">Des fragrances exclusives pour hommes et femmes</p>
            <a href="{{ route('parfums.index') }}" class="btn btn-light btn-lg mt-3">Voir la collection</a>
        </div>
    </section>

    <!-- Nouveautés Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Nos nouveautés</h2>
            <div class="row">
                @foreach($nouveautes as $parfum)
                    <div class="col-md-3 mb-4">
                        <div class="card product-card h-100">
                            @if($parfum->image)
                                <img src="{{ asset('storage/' . $parfum->image) }}" class="card-img-top" alt="{{ $parfum->nom }}">
                            @else
                                <img src="https://via.placeholder.com/300x200?text=Parfum" class="card-img-top" alt="{{ $parfum->nom }}">
                            @endif
                            <div class="card-body">
                                <span class="badge category-badge mb-2">{{ $parfum->categorie->nom }}</span>
                                <h5 class="card-title">{{ $parfum->nom }}</h5>
                                <p class="price">{{ number_format($parfum->prix, 2, ',', ' ') }} €</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('parfums.show', $parfum->id_parfum) }}" class="btn btn-sm btn-outline-primary">Voir détails</a>
                                    <form action="{{ route('panier.ajouter') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_parfum" value="{{ $parfum->id_parfum }}">
                                        <input type="hidden" name="quantite" value="1">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('parfums.index') }}" class="btn btn-primary">Voir tous les parfums</a>
            </div>
        </div>
    </section>

    <!-- Catégories Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Nos catégories</h2>
            <div class="row">
                @foreach($categories as $categorie)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h3 class="card-title">{{ $categorie->nom }}</h3>
                                <p class="card-text">{{ Str::limit($categorie->description, 100) }}</p>
                                <a href="{{ route('parfums.index', ['categorie' => $categorie->id_categorie]) }}" class="btn btn-primary">Découvrir</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Avantages Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Pourquoi nous choisir ?</h2>
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="p-3">
                        <i class="fas fa-truck fa-3x mb-3 text-primary"></i>
                        <h4>Livraison rapide</h4>
                        <p>Livraison en 24/48h partout en France</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="p-3">
                        <i class="fas fa-check-circle fa-3x mb-3 text-primary"></i>
                        <h4>Produits authentiques</h4>
                        <p>100% authentiques et garantis</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="p-3">
                        <i class="fas fa-undo fa-3x mb-3 text-primary"></i>
                        <h4>Retours gratuits</h4>
                        <p>14 jours pour changer d'avis</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="p-3">
                        <i class="fas fa-headset fa-3x mb-3 text-primary"></i>
                        <h4>Service client</h4>
                        <p>À votre écoute 7j/7</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h3>Inscrivez-vous à notre newsletter</h3>
                    <p>Recevez nos offres exclusives et nos nouveautés directement dans votre boîte mail.</p>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('newsletter.inscription') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" placeholder="Votre adresse email" required>
                            <button class="btn btn-light" type="submit">S'inscrire</button>
                        </div>
                    </form>
                    
                    {{-- Affichage du message de succès --}}
                    @if(session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </section>
@endsection