<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Models;

use Hwkdo\IntranetAppRaumverwaltung\Data\AppSettings;
use Illuminate\Database\Eloquent\Model;

class IntranetAppRaumverwaltungSettings extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'settings' => AppSettings::class.':default',
        ];
    }

    public static function current(): IntranetAppRaumverwaltungSettings|null
    {
        return self::orderBy('version', 'desc')->first();
    }
}
