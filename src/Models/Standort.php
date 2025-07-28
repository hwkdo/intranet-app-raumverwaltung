<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Models;

use Illuminate\Database\Eloquent\Model;

class Standort extends Model
{
    protected $table = 'app_raumverwaltung_standorts';
    protected $guarded = [];    

    public function gebaeude()
    {
        return $this->hasMany(Gebaeude::class);
    }
}
