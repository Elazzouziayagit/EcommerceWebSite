@extends('layouts.app')

@section('content')
    <h1>Résultats de recherche</h1>

    @if($parfums->isEmpty())
        <p>Aucun parfum trouvé.</p>
    @else
        <div class="row">
            @foreach($parfums as $parfum)
                <div class="col-md-3 mb-4">
                    <div class="card product-card h-100">
                        @if($parfum->image)
                            <img src="{{ asset('storage/' . $parfum->image) }}" class="card-img-top" alt="{{ $parfum->nom }}">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=Parfum" class="card-img-top" alt="{{ $parfum->nom }}">
                        @endif
                        <div class="card-body">
                            <span class="badge category-badge mb-2">{{ $parfum->categorie->nom ?? 'Catégorie inconnue' }}</span>
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

        <div class="d-flex justify-content-center mt-4">
            {{ $parfums->links() }} {{-- Pagination --}}
        </div>
    @endif
@endsection
