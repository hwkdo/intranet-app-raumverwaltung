<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Models;

use Hwkdo\IntranetAppRaumverwaltung\Enums\RaumartEnum;
use Hwkdo\IntranetAppRaumverwaltung\Events\NutzungsartUpdated;
use Illuminate\Database\Eloquent\Model;

class Nutzungsart extends Model
{
    protected $table = 'app_raumverwaltung_nutzungsarts';
    protected $guarded = [];
    protected $casts = [
        'raumart' => RaumartEnum::class
    ];

    protected $dispatchesEvents = [
        'updated' => NutzungsartUpdated::class,
    ];

    public function raums()
    {
        return $this->hasMany(Raum::class);
    }
}
