@extends('layouts.app')

@section('title', 'Confirmation de commande')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-check-circle text-success fa-5x mb-4"></i>
                    <h1 class="mb-4">Merci pour votre commande !</h1>
                    <p class="lead mb-4">Votre commande #{{ $commande->id_commande }} a été confirmée et est en cours de traitement.</p>
                    <p class="mb-4">Un email de confirmation a été envoyé à <strong>{{ $commande->client->email }}</strong>.</p>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('commandes.detail', $commande->id_commande) }}" class="btn btn-primary me-2">
                            <i class="fas fa-eye me-2"></i>Voir les détails
                        </a>
                        <a href="{{ route('parfums.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Continuer les achats
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Récapitulatif de la commande</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Informations de commande</h6>
                            <p class="mb-1"><strong>Numéro de commande:</strong> #{{ $commande->id_commande }}</p>
                            <p class="mb-1"><strong>Date:</strong> {{ date('d/m/Y H:i', strtotime($commande->date_commande)) }}</p>
                            <p class="mb-1"><strong>Statut:</strong> {{ $commande->statut }}</p>
                            <p class="mb-0"><strong>Total:</strong> {{ number_format($commande->total, 2, ',', ' ') }} €</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Informations de livraison</h6>
                            <p class="mb-1"><strong>Adresse:</strong> {{ $commande->livraison->adresse_livraison }}</p>
                            <p class="mb-1"><strong>Transporteur:</strong> {{ $commande->livraison->transporteur }}</p>
                            <p class="mb-0"><strong>Statut:</strong> {{ $commande->livraison->statut }}</p>
                        </div>
                    </div>

                    <h6>Articles commandés</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix unitaire</th>
                                    <th>Quantité</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commande->details as $detail)
                                    <tr>
                                        <td>{{ $detail->parfum->nom }}</td>
                                        <td>{{ number_format($detail->prix_unitaire, 2, ',', ' ') }} €</td>
                                        <td>{{ $detail->quantite }}</td>
                                        <td class="text-end">
                                            {{ number_format($detail->prix_unitaire * $detail->quantite, 2, ',', ' ') }} €
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td class="text-end"><strong>{{ number_format($commande->total, 2, ',', ' ') }} €</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <p>Des questions sur votre commande ? <a href="#">Contactez notre service client</a>.</p>
            </div>
        </div>
    </div>
</div>
@endsection
