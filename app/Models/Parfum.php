<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parfum extends Model
{
    protected $primaryKey = 'id_parfum';
    protected $table = 'parfums';

    protected $fillable = [
        'nom', 'description', 'prix', 'stock', 'image', 'id_categorie', 'date_ajout'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }

    public function detailsCommandes()
    {
        return $this->hasMany(DetailCommande::class, 'id_parfum');
    }

    public function panier()
    {
        return $this->hasMany(Panier::class, 'id_parfum');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'id_parfum');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_parfum');
    }
}