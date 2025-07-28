<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hwkdo\IntranetAppRaumverwaltung\IntranetAppRaumverwaltung
 */
class IntranetAppRaumverwaltung extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Hwkdo\IntranetAppRaumverwaltung\IntranetAppRaumverwaltung::class;
    }
}
