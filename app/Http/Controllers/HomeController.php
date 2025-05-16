<?php

namespace App\Http\Controllers;

use App\Models\Parfum;
use App\Models\Categorie;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $nouveautes = Parfum::orderBy('date_ajout', 'desc')->take(8)->get();
        $categories = Categorie::all();
        
        return view('home', compact('nouveautes', 'categories'));
    }
}