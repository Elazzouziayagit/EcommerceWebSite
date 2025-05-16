<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Livraison;
use App\Models\ActionAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with(['client', 'livraison'])
                           ->orderBy('date_commande', 'desc')
                           ->paginate(10);
        return view('admin.commandes.index', compact('commandes'));
    }
    
    public function show($id)
    {
        $commande = Commande::with(['client', 'details.parfum', 'livraison'])
                          ->findOrFail($id);
        return view('admin.commandes.show', compact('commande'));
    }
    
    public function updateStatut(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|string|in:en attente,confirmée,expédiée,livrée,annulée'
        ]);
        
        $commande = Commande::findOrFail($id);
        $commande->update([
            'statut' => $request->statut
        ]);
        
        // Enregistrer l'action
        ActionAdmin::create([
            'id_admin' => Auth::guard('admin')->id(),
            'action' => "Mise à jour du statut de la commande #{$commande->id_commande} à '{$request->statut}'",
            'date_action' => now()
        ]);
        
        return redirect()->back()->with('success', 'Statut de la commande mis à jour avec succès!');
    }
    
    public function updateLivraison(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|string|in:en préparation,en transit,livrée,échouée',
            'date_livraison' => 'nullable|date',
            'transporteur' => 'required|string'
        ]);
        
        $livraison = Livraison::where('id_commande', $id)->firstOrFail();
        $livraison->update([
            'statut' => $request->statut,
            'date_livraison' => $request->date_livraison,
            'transporteur' => $request->transporteur
        ]);
        
        // Enregistrer l'action
        ActionAdmin::create([
            'id_admin' => Auth::guard('admin')->id(),
            'action' => "Mise à jour de la livraison pour la commande #{$id}",
            'date_action' => now()
        ]);
        
        return redirect()->back()->with('success', 'Informations de livraison mises à jour avec succès!');
    }
}