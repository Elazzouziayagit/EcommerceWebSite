<?php

namespace App\Http\Controllers;

use App\Models\Parfum;
use App\Models\Categorie;
use App\Models\Avis;
use Illuminate\Http\Request;

class ParfumController extends Controller
{
    public function index(Request $request)
    {
        $query = Parfum::query();
        
        // Filtrage par catégorie
        if ($request->has('categorie')) {
            $query->where('id_categorie', $request->categorie);
        }
        
        // Filtrage par prix
        if ($request->has('prix_min') && $request->has('prix_max')) {
            $query->whereBetween('prix', [$request->prix_min, $request->prix_max]);
        }
        
        // Tri
        if ($request->has('tri')) {
            switch ($request->tri) {
                case 'prix_asc':
                    $query->orderBy('prix', 'asc');
                    break;
                case 'prix_desc':
                    $query->orderBy('prix', 'desc');
                    break;
                case 'nouveautes':
                    $query->orderBy('date_ajout', 'desc');
                    break;
                default:
                    $query->orderBy('nom', 'asc');
            }
        } else {
            $query->orderBy('nom', 'asc');
        }
        
        $parfums = $query->paginate(12);
        $categories = Categorie::all();
        
        return view('parfums.index', compact('parfums', 'categories'));
    }
    
    public function show($id)
    {
        $parfum = Parfum::findOrFail($id);
        $avis = Avis::where('id_parfum', $id)->orderBy('date_avis', 'desc')->get();
        $parfumsSimilaires = Parfum::where('id_categorie', $parfum->id_categorie)
                                  ->where('id_parfum', '!=', $id)
                                  ->take(4)
                                  ->get();
        
        return view('parfums.show', compact('parfum', 'avis', 'parfumsSimilaires'));
    }
    
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $parfums = Parfum::where('nom', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%")
                        ->paginate(12);
        
        return view('parfums.search', compact('parfums', 'query'));
    }
}