<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administrateur;
use App\Models\ActionAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
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
        
        if (Auth::guard('admin')->attempt($credentials)) {
            // Enregistrer l'action de connexion
            ActionAdmin::create([
                'id_admin' => Auth::guard('admin')->id(),
                'action' => 'Connexion au tableau de bord',
                'date_action' => now()
            ]);
            
            return redirect()->intended(route('admin.dashboard'))->with('success', 'Connexion réussie!');
        }
        
        return redirect()->back()->withInput($request->only('email'))->with('error', 'Email ou mot de passe incorrect.');
    }
    
    public function logout()
    {
        // Enregistrer l'action de déconnexion
        if (Auth::guard('admin')->check()) {
            ActionAdmin::create([
                'id_admin' => Auth::guard('admin')->id(),
                'action' => 'Déconnexion du tableau de bord',
                'date_action' => now()
            ]);
        }
        
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Déconnexion réussie!');
    }
}