<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $primaryKey = 'id_commande';
    protected $table = 'commandes';

    protected $fillable = [
        'id_client', 'date_commande', 'statut', 'total'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function details()
    {
        return $this->hasMany(DetailCommande::class, 'id_commande');
    }

    public function livraison()
    {
        return $this->hasOne(Livraison::class, 'id_commande');
    }
}