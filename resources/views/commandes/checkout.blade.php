@extends('layouts.app')

@section('title', 'Finaliser la commande')

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('panier.index') }}">Panier</a></li>
                <li class="breadcrumb-item active" aria-current="page">Finaliser la commande</li>
            </ol>
        </nav>

        <h1 class="mb-4">Finaliser votre commande</h1>

        <form action="{{ route('commandes.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <!-- Informations de livraison -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Informations de livraison</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom complet</label>
                                <input type="text" class="form-control" id="nom" value="{{ Auth::guard('client')->user()->nom }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="{{ Auth::guard('client')->user()->email }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="adresse_livraison" class="form-label">Adresse de livraison</label>
                                <textarea class="form-control" id="adresse_livraison" name="adresse_livraison" rows="3" required>{{ Auth::guard('client')->user()->adresse }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control" id="telephone" value="{{ Auth::guard('client')->user()->telephone }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Options de livraison -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Options de livraison</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="transporteur" id="transporteur1" value="Colissimo" checked>
                                <label class="form-check-label" for="transporteur1">
                                    <strong>Colissimo</strong> - Livraison standard (2-3 jours ouvrés) - Gratuit
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="transporteur" id="transporteur2" value="Chronopost">
                                <label class="form-check-label" for="transporteur2">
                                    <strong>Chronopost</strong> - Livraison express (24h) - 9,90 €
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="transporteur" id="transporteur3" value="DHL">
                                <label class="form-check-label" for="transporteur3">
                                    <strong>DHL</strong> - Livraison internationale (3-5 jours) - 14,90 €
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Méthode de paiement -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Méthode de paiement</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="paiement" id="paiement1" value="carte" checked>
                                <label class="form-check-label" for="paiement1">
                                    <i class="fab fa-cc-visa me-2"></i>Carte bancaire
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="paiement" id="paiement2" value="paypal">
                                <label class="form-check-label" for="paiement2">
                                    <i class="fab fa-paypal me-2"></i>PayPal
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paiement" id="paiement3" value="virement">
                                <label class="form-check-label" for="paiement3">
                                    <i class="fas fa-university me-2"></i>Virement bancaire
                                </label>
                            </div>
                            
                            <div id="carte-form" class="mt-4">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="card_number" class="form-label">Numéro de carte</label>
                                        <input type="text" class="form-control" id="card_number" placeholder="1234 5678 9012 3456">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="card_name" class="form-label">Nom sur la carte</label>
                                        <input type="text" class="form-control" id="card_name" placeholder="John Doe">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="card_expiry" class="form-label">Date d'expiration</label>
                                        <input type="text" class="form-control" id="card_expiry" placeholder="MM/AA">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="card_cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="card_cvv" placeholder="123">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Récapitulatif de la commande -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Récapitulatif de la commande</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th>Qté</th>
                                            <th class="text-end">Prix</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($panierItems as $item)
                                            <tr>
                                                <td>{{ $item->parfum->nom }}</td>
                                                <td>{{ $item->quantite }}</td>
                                                <td class="text-end">{{ number_format($item->parfum->prix * $item->quantite, 2, ',', ' ') }} €</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Sous-total</span>
                                <span>{{ number_format($total, 2, ',', ' ') }} €</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Livraison</span>
                                <span>Gratuite</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>TVA (20%)</span>
                                <span>{{ number_format($total * 0.2, 2, ',', ' ') }} €</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <strong>Total</strong>
                                <strong>{{ number_format($total, 2, ',', ' ') }} €</strong>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="conditions" required>
                                <label class="form-check-label" for="conditions">
                                    J'accepte les <a href="#">conditions générales de vente</a>
                                </label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-lock me-2"></i>Confirmer et payer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('input[name="paiement"]').change(function() {
            if ($(this).val() === 'carte') {
                $('#carte-form').show();
            } else {
                $('#carte-form').hide();
            }
        });
    });
</script>
@endsection