<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Models;

use Hwkdo\IntranetAppRaumverwaltung\Enums\PriSekEnum;
use Hwkdo\IntranetAppRaumverwaltung\Exports\RaumExport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Maatwebsite\Excel\Facades\Excel;
use Mpociot\Versionable\VersionableTrait;

class Raum extends Model
{    
    use VersionableTrait, SoftDeletes;

    protected $table = 'app_raumverwaltung_raums';
    protected $guarded = [];
    protected $casts = [
        'pri_sek' => PriSekEnum::class,
        'gueltig_ab' => 'date',
        'gueltig_bis' => 'date',
        'einheit_gueltig_ab' => 'date',
        'einheit_gueltig_bis' => 'date',
    ];
    
    public static function generateNumber(
        int $gebaeude_id,
        int $etage_id,
        int $nutzungsart_id,
        int $lfd_nr,
    )
    {
        $gebaeude = Gebaeude::findOrFail($gebaeude_id);
        $etage = Etage::findOrFail($etage_id);
        $nutzungsart = Nutzungsart::findOrFail($nutzungsart_id);
        $lfd_nr = $lfd_nr < 10 ? '0'.$lfd_nr : $lfd_nr;
        
        return $gebaeude->standort->zeichen.'-'.$nutzungsart->zeichen.'-'.$gebaeude->zeichen.$etage->zeichen.$lfd_nr;
    }

    public function generateMyNumber()
    {
        if($this->gebaeude_id && $this->etage_id && $this->nutzungsart_id && $this->lfd_nr)
        {
            return self::generateNumber($this->gebaeude_id, $this->etage_id, $this->nutzungsart_id, $this->lfd_nr);        
        }
        else return null;
    }

    public static function exportExcel(?array $ids = null)
    {
        if($ids)
        {
            $raume = Raum::whereIn('id', $ids)->get();
        }
        else {
            $raume = Raum::all();
        }
        return Excel::download(new RaumExport($raume), 'raume.xlsx');
    }

    public function getIstGueltigAttribute()
    {
        return $this->gueltig_bis <= now() && $this->gueltig_ab >= now();
    }

    public function etage()
    {
        return $this->belongsTo(Etage::class);
    }

    public function nutzungsart()
    {
        return $this->belongsTo(Nutzungsart::class);
    }

    public function gebaeude() 
    {
        return $this->belongsTo(Gebaeude::class);
    }   

    public function fachbereich()
    {
        return $this->belongsTo(Fachbereich::class);
    }


}
