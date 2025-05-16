<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ParfumController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ParfumController as AdminParfumController;
use App\Http\Controllers\Admin\CategorieController as AdminCategorieController;
use App\Http\Controllers\Admin\CommandeController as AdminCommandeController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\NewsletterController; // ✅ Ajout pour la newsletter

/*
|--------------------------------------------------------------------------
| Routes Frontend
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// ✅ Route d'inscription à la newsletter
Route::post('/newsletter', [NewsletterController::class, 'inscription'])->name('newsletter.inscription');

// Routes pour les parfums
Route::get('/parfums', [ParfumController::class, 'index'])->name('parfums.index');
Route::get('/parfums/{id}', [ParfumController::class, 'show'])->name('parfums.show');
Route::get('/recherche', [ParfumController::class, 'search'])->name('parfums.search');

// Routes pour le panier
Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
Route::post('/panier/ajouter', [PanierController::class, 'ajouter'])->name('panier.ajouter');
Route::delete('/panier/supprimer', [PanierController::class, 'supprimer'])->name('panier.supprimer');
Route::put('/panier/mettre-a-jour', [PanierController::class, 'mettreAJour'])->name('panier.mettreAJour');

// Routes pour les commandes
Route::get('/commande/checkout', [CommandeController::class, 'checkout'])->name('commandes.checkout');
Route::post('/commande/store', [CommandeController::class, 'store'])->name('commandes.store');
Route::get('/commande/confirmation/{id}', [CommandeController::class, 'confirmation'])->name('commandes.confirmation');
Route::get('/commande/historique', [CommandeController::class, 'historique'])->name('commandes.historique');
Route::get('/commande/detail/{id}', [CommandeController::class, 'detail'])->name('commandes.detail');

// Routes pour les avis
Route::post('/avis', [AvisController::class, 'store'])->name('avis.store');

// Routes pour l'authentification client
Route::get('/client/login', [ClientController::class, 'showLoginForm'])->name('client.login');
Route::post('/client/login', [ClientController::class, 'login'])->name('client.login.post');
Route::get('/client/register', [ClientController::class, 'showRegisterForm'])->name('client.register');
Route::post('/client/register', [ClientController::class, 'register'])->name('client.register.post');
Route::post('/client/logout', [ClientController::class, 'logout'])->name('client.logout');

// Routes pour le profil client (protégées)
Route::middleware(['auth:client'])->group(function () {
    Route::get('/client/profile', [ClientController::class, 'profile'])->name('client.profile');
    Route::put('/client/profile', [ClientController::class, 'updateProfile'])->name('client.profile.update');
    Route::put('/client/password', [ClientController::class, 'updatePassword'])->name('client.password.update');
});

/*
|--------------------------------------------------------------------------
| Routes Backend (Admin)
|--------------------------------------------------------------------------
*/

// Routes pour l'authentification admin
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Routes admin protégées
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des parfums
    Route::resource('parfums', AdminParfumController::class);
    
    // Gestion des catégories
    Route::resource('categories', AdminCategorieController::class);
    
    // Gestion des commandes
    Route::get('commandes', [AdminCommandeController::class, 'index'])->name('commandes.index');
    Route::get('commandes/{id}', [AdminCommandeController::class, 'show'])->name('commandes.show');
    Route::put('commandes/{id}/statut', [AdminCommandeController::class, 'updateStatut'])->name('commandes.updateStatut');
    Route::put('commandes/{id}/livraison', [AdminCommandeController::class, 'updateLivraison'])->name('commandes.updateLivraison');
    
    // Gestion des clients
    Route::get('clients', [AdminClientController::class, 'index'])->name('clients.index');
    Route::get('clients/{id}', [AdminClientController::class, 'show'])->name('clients.show');
});
