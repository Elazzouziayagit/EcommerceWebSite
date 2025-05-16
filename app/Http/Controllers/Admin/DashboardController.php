<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Client;
use App\Models\Parfum;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $totalClients = Client::count();
        $totalParfums = Parfum::count();
        $totalCommandes = Commande::count();
        $chiffreAffaires = Commande::where('statut', '!=', 'annulée')->sum('total');
        
        // Commandes récentes
        $commandesRecentes = Commande::with('client')
                                   ->orderBy('date_commande', 'desc')
                                   ->take(5)
                                   ->get();
        
        // Statistiques des ventes par mois
        $ventesMensuelles = Commande::select(
                                DB::raw('MONTH(date_commande) as mois'),
                                DB::raw('YEAR(date_commande) as annee'),
                                DB::raw('SUM(total) as total')
                            )
                            ->where('statut', '!=', 'annulée')
                            ->whereYear('date_commande', date('Y'))
                            ->groupBy('mois', 'annee')
                            ->orderBy('annee')
                            ->orderBy('mois')
                            ->get();
        
        // Top 5 des parfums les plus vendus
        $topParfums = DB::table('details_commandes')
                      ->join('parfums', 'details_commandes.id_parfum', '=', 'parfums.id_parfum')
                      ->select('parfums.id_parfum', 'parfums.nom', DB::raw('SUM(details_commandes.quantite) as total_vendu'))
                      ->groupBy('parfums.id_parfum', 'parfums.nom')
                      ->orderBy('total_vendu', 'desc')
                      ->take(5)
                      ->get();
        
        return view('admin.dashboard', compact(
            'totalClients',
            'totalParfums',
            'totalCommandes',
            'chiffreAffaires',
            'commandesRecentes',
            'ventesMensuelles',
            'topParfums'
        ));
    }
}