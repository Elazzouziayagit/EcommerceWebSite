<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Parfum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_parfum' => 'required|exists:parfums,id_parfum',
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'required|string'
        ]);
        
        if (!Auth::guard('client')->check()) {
            return redirect()->route('client.login')->with('error', 'Veuillez vous connecter pour laisser un avis.');
        }
        
        // Vérifier si le client a déjà laissé un avis pour ce parfum
        $avisExistant = Avis::where('id_client', Auth::guard('client')->id())
                          ->where('id_parfum', $request->id_parfum)
                          ->first();
        
        if ($avisExistant) {
            return redirect()->back()->with('error', 'Vous avez déjà laissé un avis pour ce parfum.');
        }
        
        Avis::create([
            'id_client' => Auth::guard('client')->id(),
            'id_parfum' => $request->id_parfum,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
            'date_avis' => now()
        ]);
        
        return redirect()->back()->with('success', 'Votre avis a été ajouté avec succès!');
    }
}