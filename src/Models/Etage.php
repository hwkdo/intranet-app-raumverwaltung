<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Models;

use Hwkdo\IntranetAppRaumverwaltung\Events\EtageUpdated;
use Illuminate\Database\Eloquent\Model;

class Etage extends Model
{
    protected $table = 'app_raumverwaltung_etages';

    protected $guarded = [];

    protected $dispatchesEvents = [
        'updated' => EtageUpdated::class,
    ];

    public function raums()
    {
        return $this->hasMany(Raum::class);
    }
}
