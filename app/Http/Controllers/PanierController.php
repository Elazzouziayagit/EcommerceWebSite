<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Parfum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PanierController extends Controller
{
    public function index()
    {
        if (Auth::guard('client')->check()) {
            // Utilisateur connecté - récupérer le panier depuis la base de données
            $panierItems = Panier::where('id_client', Auth::guard('client')->id())
                                ->with('parfum')
                                ->get();
        } else {
            // Utilisateur non connecté - récupérer le panier depuis la session
            $panierItems = collect();
            $panier = Session::get('panier', []);
            
            foreach ($panier as $id => $details) {
                $parfum = Parfum::find($id);
                if ($parfum) {
                    $item = new \stdClass();
                    $item->parfum = $parfum;
                    $item->quantite = $details['quantite'];
                    $panierItems->push($item);
                }
            }
        }
        
        $total = $panierItems->sum(function($item) {
            return $item->parfum->prix * $item->quantite;
        });
        
        return view('panier.index', compact('panierItems', 'total'));
    }
    
    public function ajouter(Request $request)
    {
        $request->validate([
            'id_parfum' => 'required|exists:parfums,id_parfum',
            'quantite' => 'required|integer|min:1'
        ]);
        
        $parfum = Parfum::findOrFail($request->id_parfum);
        
        if (Auth::guard('client')->check()) {
            // Utilisateur connecté - ajouter au panier dans la base de données
            $panierItem = Panier::where('id_client', Auth::guard('client')->id())
                               ->where('id_parfum', $request->id_parfum)
                               ->first();
            
            if ($panierItem) {
                // Mettre à jour la quantité si l'article existe déjà
                $panierItem->quantite += $request->quantite;
                $panierItem->save();
            } else {
                // Créer un nouvel article dans le panier
                Panier::create([
                    'id_client' => Auth::guard('client')->id(),
                    'id_parfum' => $request->id_parfum,
                    'quantite' => $request->quantite,
                    'date_ajout' => now()
                ]);
            }
        } else {
            // Utilisateur non connecté - ajouter au panier dans la session
            $panier = Session::get('panier', []);
            
            if (isset($panier[$request->id_parfum])) {
                $panier[$request->id_parfum]['quantite'] += $request->quantite;
            } else {
                $panier[$request->id_parfum] = [
                    'quantite' => $request->quantite
                ];
            }
            
            Session::put('panier', $panier);
        }
        
        return redirect()->back()->with('success', 'Produit ajouté au panier avec succès!');
    }
    
    public function supprimer(Request $request)
    {
        if (Auth::guard('client')->check()) {
            // Utilisateur connecté - supprimer du panier dans la base de données
            Panier::where('id_client', Auth::guard('client')->id())
                 ->where('id_parfum', $request->id_parfum)
                 ->delete();
        } else {
            // Utilisateur non connecté - supprimer du panier dans la session
            $panier = Session::get('panier', []);
            
            if (isset($panier[$request->id_parfum])) {
                unset($panier[$request->id_parfum]);
                Session::put('panier', $panier);
            }
        }
        
        return redirect()->back()->with('success', 'Produit retiré du panier avec succès!');
    }
    
    public function mettreAJour(Request $request)
    {
        $request->validate([
            'quantite' => 'required|array',
            'quantite.*' => 'required|integer|min:1'
        ]);
        
        if (Auth::guard('client')->check()) {
            // Utilisateur connecté - mettre à jour le panier dans la base de données
            foreach ($request->quantite as $id => $quantite) {
                Panier::where('id_client', Auth::guard('client')->id())
                     ->where('id_parfum', $id)
                     ->update(['quantite' => $quantite]);
            }
        } else {
            // Utilisateur non connecté - mettre à jour le panier dans la session
            $panier = Session::get('panier', []);
            
            foreach ($request->quantite as $id => $quantite) {
                if (isset($panier[$id])) {
                    $panier[$id]['quantite'] = $quantite;
                }
            }
            
            Session::put('panier', $panier);
        }
        
        return redirect()->back()->with('success', 'Panier mis à jour avec succès!');
    }
}