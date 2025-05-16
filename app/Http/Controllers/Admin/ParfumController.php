<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Parfum;
use App\Models\Categorie;
use App\Models\ActionAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ParfumController extends Controller
{
    public function index()
    {
        $parfums = Parfum::with('categorie')->paginate(10);
        return view('admin.parfums.index', compact('parfums'));
    }
    
    public function create()
    {
        $categories = Categorie::all();
        return view('admin.parfums.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'id_categorie' => 'required|exists:categories,id_categorie',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('parfums', 'public');
        }
        
        $parfum = Parfum::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'stock' => $request->stock,
            'image' => $imagePath,
            'id_categorie' => $request->id_categorie,
            'date_ajout' => now()
        ]);
        
        // Enregistrer l'action
        ActionAdmin::create([
            'id_admin' => Auth::guard('admin')->id(),
            'action' => "Ajout du parfum: {$parfum->nom}",
            'date_action' => now()
        ]);
        
        return redirect()->route('admin.parfums.index')->with('success', 'Parfum ajouté avec succès!');
    }
    
    public function edit($id)
    {
        $parfum = Parfum::findOrFail($id);
        $categories = Categorie::all();
        return view('admin.parfums.edit', compact('parfum', 'categories'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'id_categorie' => 'required|exists:categories,id_categorie',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $parfum = Parfum::findOrFail($id);
        
        $imagePath = $parfum->image;
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($parfum->image) {
                Storage::disk('public')->delete($parfum->image);
            }
            $imagePath = $request->file('image')->store('parfums', 'public');
        }
        
        $parfum->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'stock' => $request->stock,
            'image' => $imagePath,
            'id_categorie' => $request->id_categorie
        ]);
        
        // Enregistrer l'action
        ActionAdmin::create([
            'id_admin' => Auth::guard('admin')->id(),
            'action' => "Modification du parfum: {$parfum->nom}",
            'date_action' => now()
        ]);
        
        return redirect()->route('admin.parfums.index')->with('success', 'Parfum mis à jour avec succès!');
    }
    
    public function destroy($id)
    {
        $parfum = Parfum::findOrFail($id);
        
        // Supprimer l'image si elle existe
        if ($parfum->image) {
            Storage::disk('public')->delete($parfum->image);
        }
        
        $nomParfum = $parfum->nom;
        $parfum->delete();
        
        // Enregistrer l'action
        ActionAdmin::create([
            'id_admin' => Auth::guard('admin')->id(),
            'action' => "Suppression du parfum: {$nomParfum}",
            'date_action' => now()
        ]);
        
        return redirect()->route('admin.parfums.index')->with('success', 'Parfum supprimé avec succès!');
    }
}