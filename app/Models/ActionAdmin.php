<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionAdmin extends Model
{
    protected $primaryKey = 'id_action';
    protected $table = 'actions_admin';

    protected $fillable = [
        'id_admin', 'action', 'date_action'
    ];

    public function administrateur()
    {
        return $this->belongsTo(Administrateur::class, 'id_admin');
    }
}