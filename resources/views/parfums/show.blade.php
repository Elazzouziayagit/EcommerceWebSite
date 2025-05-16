@extends('layouts.app')

@section('title', $parfum->nom)

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('parfums.index') }}">Parfums</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $parfum->nom }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Image du parfum -->
            <div class="col-md-5 mb-4">
                <div class="card">
                    @if($parfum->image)
                        <img src="{{ asset('storage/' . $parfum->image) }}" class="card-img-top" alt="{{ $parfum->nom }}">
                    @else
                        <img src="https://via.placeholder.com/600x400?text=Parfum" class="card-img-top" alt="{{ $parfum->nom }}">
                    @endif
                </div>
            </div>

            <!-- Détails du parfum -->
            <div class="col-md-7 mb-4">
                <h1 class="mb-2">{{ $parfum->nom }}</h1>
                <span class="badge category-badge mb-3">{{ $parfum->categorie->nom }}</span>
                
                <div class="mb-3">
                    @php
                        $noteMoyenne = $avis->avg('note') ?? 0;
                        $nbAvis = $avis->count();
                    @endphp
                    <div class="rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $noteMoyenne)
                                <i class="fas fa-star"></i>
                            @elseif($i - 0.5 <= $noteMoyenne)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                        <span class="ms-2 text-muted">{{ number_format($noteMoyenne, 1) }}/5 ({{ $nbAvis }} avis)</span>
                    </div>
                </div>
                
                <h2 class="price mb-3">{{ number_format($parfum->prix, 2, ',', ' ') }} €</h2>
                
                <p class="mb-4">{{ $parfum->description }}</p>
                
                <div class="mb-4">
                    <p class="mb-1">
                        <strong>Disponibilité:</strong> 
                        @if($parfum->stock > 0)
                            <span class="text-success">En stock ({{ $parfum->stock }} disponibles)</span>
                        @else
                            <span class="text-danger">Rupture de stock</span>
                        @endif
                    </p>
                    <p class="mb-1"><strong>Catégorie:</strong> {{ $parfum->categorie->nom }}</p>
                    <p class="mb-0"><strong>Date d'ajout:</strong> {{ date('d/m/Y', strtotime($parfum->date_ajout)) }}</p>
                </div>
                
                @if($parfum->stock > 0)
                    <form action="{{ route('panier.ajouter') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="id_parfum" value="{{ $parfum->id_parfum }}">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="quantite" class="col-form-label">Quantité:</label>
                            </div>
                            <div class="col-auto">
                                <input type="number" id="quantite" name="quantite" class="form-control" value="1" min="1" max="{{ $parfum->stock }}">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-cart-plus me-2"></i>Ajouter au panier
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <button class="btn btn-secondary mb-4" disabled>
                        <i class="fas fa-cart-plus me-2"></i>Indisponible
                    </button>
                @endif
                
                <div class="d-flex">
                    <button class="btn btn-outline-primary me-2">
                        <i class="far fa-heart me-1"></i>Ajouter aux favoris
                    </button>
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-share-alt me-1"></i>Partager
                    </button>
                </div>
            </div>
        </div>

        <!-- Onglets d'information -->
        <div class="row mt-4">
            <div class="col-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="avis-tab" data-bs-toggle="tab" data-bs-target="#avis" type="button" role="tab">Avis ({{ $avis->count() }})</button>
                    </li>
                </ul>
                <div class="tab-content p-4 border border-top-0 rounded-bottom" id="myTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <p>{{ $parfum->description }}</p>
                    </div>
                    <div class="tab-pane fade" id="avis" role="tabpanel">
                        <!-- Formulaire d'avis -->
                        @if(Auth::guard('client')->check())
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Laisser un avis</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('avis.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_parfum" value="{{ $parfum->id_parfum }}">
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Note</label>
                                            <div class="rating-input">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="note" id="note1" value="1" required>
                                                    <label class="form-check-label" for="note1">1</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="note" id="note2" value="2">
                                                    <label class="form-check-label" for="note2">2</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="note" id="note3" value="3">
                                                    <label class="form-check-label" for="note3">3</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="note" id="note4" value="4">
                                                    <label class="form-check-label" for="note4">4</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="note" id="note5" value="5">
                                                    <label class="form-check-label" for="note5">5</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="commentaire" class="form-label">Commentaire</label>
                                            <textarea class="form-control" id="commentaire" name="commentaire" rows="3" required></textarea>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary">Soumettre</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info mb-4">
                                <a href="{{ route('client.login') }}">Connectez-vous</a> pour laisser un avis.
                            </div>
                        @endif
                        
                        <!-- Liste des avis -->
                        @if($avis->count() > 0)
                            <div class="list-group">
                                @foreach($avis as $a)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-1">{{ $a->client->nom }}</h6>
                                            <small class="text-muted">{{ date('d/m/Y', strtotime($a->date_avis)) }}</small>
                                        </div>
                                        <div class="rating mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $a->note)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <p class="mb-1">{{ $a->commentaire }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">
                                Aucun avis pour ce parfum.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Parfums similaires -->
        @if($parfumsSimilaires->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-4">Vous pourriez aussi aimer</h3>
                    <div class="row">
                        @foreach($parfumsSimilaires as $similaire)
                            <div class="col-md-3 mb-4">
                                <div class="card product-card h-100">
                                    @if($similaire->image)
                                        <img src="{{ asset('storage/' . $similaire->image) }}" class="card-img-top" alt="{{ $similaire->nom }}">
                                    @else
                                        <img src="https://via.placeholder.com/300x200?text=Parfum" class="card-img-top" alt="{{ $similaire->nom }}">
                                    @endif
                                    <div class="card-body">
                                        <span class="badge category-badge mb-2">{{ $similaire->categorie->nom }}</span>
                                        <h5 class="card-title">{{ $similaire->nom }}</h5>
                                        <p class="price">{{ number_format($similaire->prix, 2, ',', ' ') }} €</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="{{ route('parfums.show', $similaire->id_parfum) }}" class="btn btn-sm btn-outline-primary">Voir détails</a>
                                            <form action="{{ route('panier.ajouter') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id_parfum" value="{{ $similaire->id_parfum }}">
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
                </div>
            </div>
        @endif
    </div>
@endsection