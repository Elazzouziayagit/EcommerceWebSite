<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Panier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    public function showLoginForm()
    {
        return view('client.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        
        if (Auth::guard('client')->attempt($credentials)) {
            // Fusionner le panier de la session avec le panier de la base de données
            $this->mergePanier();
            
            return redirect()->intended(route('home'))->with('success', 'Connexion réussie!');
        }
        
        return redirect()->back()->withInput($request->only('email'))->with('error', 'Email ou mot de passe incorrect.');
    }
    
    public function showRegisterForm()
    {
        return view('client.register');
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|string|min:8|confirmed',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:20'
        ]);
        
        $client = Client::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->password),
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'date_inscription' => now()
        ]);
        
        Auth::guard('client')->login($client);
        
        // Fusionner le panier de la session avec le panier de la base de données
        $this->mergePanier();
        
        return redirect()->route('home')->with('success', 'Inscription réussie!');
    }
    
    public function logout()
    {
        Auth::guard('client')->logout();
        return redirect()->route('home')->with('success', 'Déconnexion réussie!');
    }
    
    public function profile()
    {
        $client = Auth::guard('client')->user();
        return view('client.profile', compact('client'));
    }
    
    public function updateProfile(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:20'
        ]);
        
        $client = Auth::guard('client')->user();
        $client->update([
            'nom' => $request->nom,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone
        ]);
        
        return redirect()->back()->with('success', 'Profil mis à jour avec succès!');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ]);
        
        $client = Auth::guard('client')->user();
        
        if (!Hash::check($request->current_password, $client->mot_de_passe)) {
            return redirect()->back()->with('error', 'Le mot de passe actuel est incorrect.');
        }
        
        $client->update([
            'mot_de_passe' => Hash::make($request->password)
        ]);
        
        return redirect()->back()->with('success', 'Mot de passe mis à jour avec succès!');
    }
    
    private function mergePanier()
    {
        $sessionPanier = Session::get('panier', []);
        
        if (!empty($sessionPanier)) {
            foreach ($sessionPanier as $id => $details) {
                $panierItem = Panier::where('id_client', Auth::guard('client')->id())
                                   ->where('id_parfum', $id)
                                   ->first();
                
                if ($panierItem) {
                    // Mettre à jour la quantité si l'article existe déjà
                    $panierItem->quantite += $details['quantite'];
                    $panierItem->save();
                } else {
                    // Créer un nouvel article dans le panier
                    Panier::create([
                        'id_client' => Auth::guard('client')->id(),
                        'id_parfum' => $id,
                        'quantite' => $details['quantite'],
                        'date_ajout' => now()
                    ]);
                }
            }
            
            // Vider le panier de la session
            Session::forget('panier');
        }
    }
}