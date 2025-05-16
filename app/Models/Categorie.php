<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $primaryKey = 'id_categorie';
    protected $table = 'categories';

    protected $fillable = [
        'nom', 'description'
    ];

    public function parfums()
    {
        return $this->hasMany(Parfum::class, 'id_categorie');
    }
}