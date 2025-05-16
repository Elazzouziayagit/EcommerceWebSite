<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Commande;
use App\Models\ActionAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::paginate(10);
        return view('admin.clients.index', compact('clients'));
    }
    
    public function show($id)
    {
        $client = Client::findOrFail($id);
        $commandes = Commande::where('id_client', $id)
                           ->orderBy('date_commande', 'desc')
                           ->paginate(5);
        
        return view('admin.clients.show', compact('client', 'commandes'));
    }
}