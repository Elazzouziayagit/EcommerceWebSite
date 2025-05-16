@extends('layouts.app')

@section('title', 'Nos Parfums')

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Parfums</li>
            </ol>
        </nav>

        <h1 class="mb-4">Nos Parfums</h1>

        <div class="row">
            <!-- Filtres -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Filtres</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('parfums.index') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label">Catégories</label>
                                @foreach($categories as $categorie)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="categorie" id="cat{{ $categorie->id_categorie }}" value="{{ $categorie->id_categorie }}" {{ request('categorie') == $categorie->id_categorie ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cat{{ $categorie->id_categorie }}">
                                            {{ $categorie->nom }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Prix</label>
                                <div class="d-flex">
                                    <input type="number" class="form-control form-control-sm me-2" name="prix_min" placeholder="Min" value="{{ request('prix_min') }}">
                                    <input type="number" class="form-control form-control-sm" name="prix_max" placeholder="Max" value="{{ request('prix_max') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Trier par</label>
                                <select class="form-select form-select-sm" name="tri">
                                    <option value="nom_asc" {{ request('tri') == 'nom_asc' ? 'selected' : '' }}>Nom (A-Z)</option>
                                    <option value="nom_desc" {{ request('tri') == 'nom_desc' ? 'selected' : '' }}>Nom (Z-A)</option>
                                    <option value="prix_asc" {{ request('tri') == 'prix_asc' ? 'selected' : '' }}>Prix croissant</option>
                                    <option value="prix_desc" {{ request('tri') == 'prix_desc' ? 'selected' : '' }}>Prix décroissant</option>
                                    <option value="nouveautes" {{ request('tri') == 'nouveautes' ? 'selected' : '' }}>Nouveautés</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Appliquer</button>
                            <a href="{{ route('parfums.index') }}" class="btn btn-outline-secondary w-100 mt-2">Réinitialiser</a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Liste des parfums -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="mb-0">{{ $parfums->total() }} résultats</p>
                </div>

                <div class="row">
                    @forelse($parfums as $parfum)
                        <div class="col-md-4 mb-4">
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
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                Aucun parfum trouvé. Veuillez modifier vos filtres.
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $parfums->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection