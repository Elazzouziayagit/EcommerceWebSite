<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    protected $primaryKey = 'id_panier';
    protected $table = 'panier';

    protected $fillable = [
        'id_client', 'id_parfum', 'quantite', 'date_ajout'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function parfum()
    {
        return $this->belongsTo(Parfum::class, 'id_parfum');
    }
}