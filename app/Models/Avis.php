<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    protected $primaryKey = 'id_avis';
    protected $table = 'avis';

    protected $fillable = [
        'id_client', 'id_parfum', 'note', 'commentaire', 'date_avis'
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