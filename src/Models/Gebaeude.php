<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Models;

use Hwkdo\IntranetAppRaumverwaltung\Events\GebaeudeUpdated;
use Illuminate\Database\Eloquent\Model;

class Gebaeude extends Model
{
    protected $table = 'app_raumverwaltung_gebaeudes';
    protected $guarded = [];
    
    public function standort()
    {
        return $this->belongsTo(Standort::class);
    }

    protected $dispatchesEvents = [
        'updated' => GebaeudeUpdated::class,
    ];

    public function raums()
    {
        return $this->hasMany(Raum::class);
    }
}
