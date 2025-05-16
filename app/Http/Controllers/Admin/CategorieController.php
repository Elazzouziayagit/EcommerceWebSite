<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\ActionAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::paginate(10);
        return view('admin.categories.index', compact('categories'));
    }
    
    public function create()
    {
        return view('admin.categories.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'nullable|string'
        ]);
        
        $categorie = Categorie::create([
            'nom' => $request->nom,
            'description' => $request->description
        ]);
        
        // Enregistrer l'action
        ActionAdmin::create([
            'id_admin' => Auth::guard('admin')->id(),
            'action' => "Ajout de la catégorie: {$categorie->nom}",
            'date_action' => now()
        ]);
        
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie ajoutée avec succès!');
    }
    
    public function edit($id)
    {
        $categorie = Categorie::findOrFail($id);
        return view('admin.categories.edit', compact('categorie'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'nullable|string'
        ]);
        
        $categorie = Categorie::findOrFail($id);
        $categorie->update([
            'nom' => $request->nom,
            'description' => $request->description
        ]);
        
        // Enregistrer l'action
        ActionAdmin::create([
            'id_admin' => Auth::guard('admin')->id(),
            'action' => "Modification de la catégorie: {$categorie->nom}",
            'date_action' => now()
        ]);
        
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès!');
    }
    
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);
        
        // Vérifier si la catégorie contient des parfums
        if ($categorie->parfums()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Impossible de supprimer cette catégorie car elle contient des parfums.');
        }
        
        $nomCategorie = $categorie->nom;
        $categorie->delete();
        
        // Enregistrer l'action
        ActionAdmin::create([
            'id_admin' => Auth::guard('admin')->id(),
            'action' => "Suppression de la catégorie: {$nomCategorie}",
            'date_action' => now()
        ]);
        
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée avec succès!');
    }
}