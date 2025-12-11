<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Services;

use Hwkdo\SeventhingsLaravel\SeventhingsLaravelFacade;
use Illuminate\Support\Facades\DB;

class BueItexiaIntegrationService
{
    public static function getBueRaeume()
    {
        return DB::connection(config('bue-laravel.database.connection'))->table('intranet.v_raumliste')->select('*')->get();
    }

    public static function getBueRaeumeFormat()
    {
        return collect(self::getBueRaeume())->map(function ($row) {
            return collect([
                'source' => 'bue',
                'bue_id' => $row->id,
                'name' => $row->raumnummer,
            ]);
        });
    }

    public static function getItexiaRaeumeFormat()
    {
        return collect(SeventhingsLaravelFacade::getRaeume())->map(function ($row) {
            return collect([
                'source' => 'itexia',
                'itexia_id' => $row->id,
                'name' => $row->nummer,
            ]);
        });
    }

    public static function compareRaeumeFilter()
    {
        $bue = self::getBueRaeumeFormat();
        $itexia = self::getItexiaRaeumeFormat();
        $result = collect();

        foreach ($itexia as $row) {
            if (isset($row['name'])) {
                $inBue = $bue->filter(function ($bueRow) use ($row) {
                    if (isset($bueRow['name'])) {
                        return strpos($bueRow['name'], $row['name']) !== false;
                    }

                    return false;

                });
                if (count($inBue) == 1) {
                    $row->put('bue_id', $inBue->first()['bue_id']);
                    $result->push($row);
                } elseif (count($inBue) > 1) {
                    echo $row['name'].' found: '.count($inBue);
                }
            }
        }

        return $result;

    }
}