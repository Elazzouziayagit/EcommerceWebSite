<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    protected $primaryKey = 'id_livraison';
    protected $table = 'livraisons';

    protected $fillable = [
        'id_commande', 'adresse_livraison', 'date_livraison', 'transporteur', 'statut'
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'id_commande');
    }
}