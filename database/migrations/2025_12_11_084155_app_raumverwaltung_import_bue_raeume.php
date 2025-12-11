<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Gebaeude;
use Hwkdo\IntranetAppRaumverwaltung\Models\Raum;
use Hwkdo\IntranetAppRaumverwaltung\Models\Standort;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Hwkdo\IntranetAppRaumverwaltung\Services\BueItexiaIntegrationService;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach(BueItexiaIntegrationService::getBueRaeume() as $bue)
        {
            $standort_bza = Standort::where('kurz', 'BZA')->first();
            $standort_soest = Standort::where('kurz', 'BZS')->first();
            $standort_ruhr = Standort::where('kurz', 'BZR')->first();
            $standort_koerne = Standort::where('kurz', 'BZK')->first();
            $standort_bzh = Standort::where('kurz', 'BZH')->first();            
            $standort_extern = Standort::where('kurz', 'EXT')->first();
            $data = [];
            $data['bue_id'] = (int)$bue->id;
            if(isset($bue->gueltig_ab)) $data['gueltig_ab'] = $bue->gueltig_ab;
            if(isset($bue->gueltig_bis)) $data['gueltig_bis'] = $bue->gueltig_bis;    
            if(isset($bue->kurzzeichen)) $data['kurzzeichen'] = $bue->kurzzeichen;
            if(isset($bue->druckbezeichnung)) $data['druckbezeichnung'] = $bue->druckbezeichnung;
            if(isset($bue->raumnummer)) $data['raumnummer'] = $bue->raumnummer;
            if(isset($bue->plaetze)) $data['plaetze'] = (int)$bue->plaetze;
            if(isset($bue->plaetzefoerderfÄhig)) $data['plaetze_ff'] = (int)$bue->plaetzefoerderfÄhig;
            if(isset($bue->flaeche)) $data['qm'] = (float)$bue->flaeche;

            if(isset($bue->name))
            {
                if($bue->name == 'Handwerkskammer Dortmund Bildungszentrum Standort Ruhr')
                {
                    $data['gebaeude_id'] = Gebaeude::where('standort_id', $standort_ruhr->id)->first()->id;
                }
                elseif ($bue->name == 'Handwerkskammer Dortmund Bildungszentrum Hansemann')
                {
                    $data['gebaeude_id'] = Gebaeude::where('standort_id', $standort_bzh->id)->first()->id;
                }
                elseif ($bue->name == 'Handwerkskammer Dortmund Bildungszentrum')
                {
                    $data['gebaeude_id'] = Gebaeude::where('standort_id', $standort_bza->id)->first()->id;
                }
                elseif($bue->name == 'Handwerkskammer Dortmund Bildungszentrum Bau Standort Körne')
                {
                    $data['gebaeude_id'] = Gebaeude::where('standort_id', $standort_koerne->id)->where('zeichen','B')->first()->id;
                }
                elseif($bue->name == 'Handwerkskammer Dortmund Bildungszentrum Standort Körne')
                {
                    $data['gebaeude_id'] = Gebaeude::where('standort_id', $standort_koerne->id)->where('zeichen','A')->first()->id;
                }
                elseif($bue->name == 'Schulungsstätte der Gebäudereiniger-Innung Dortmund')
                {
                    $data['gebaeude_id'] = Gebaeude::where('standort_id', $standort_koerne->id)->where('zeichen','G')->first()->id;
                }
                elseif($bue->name == 'Kompetenzzentrum Friseur')
                {
                    $data['gebaeude_id'] = Gebaeude::where('standort_id', $standort_koerne->id)->where('zeichen','F')->first()->id;
                }
                elseif($bue->name == 'Handwerkskammer Dortmund Bildungszentrum Standort Soest')
                {
                    $data['gebaeude_id'] = Gebaeude::where('standort_id', $standort_soest->id)->first()->id;
                }
                else {
                    $gebauedeNeu = Gebaeude::where('bezeichnung', $bue->name)->first();
                    if($gebauedeNeu) {
                        $data['gebaeude_id'] = $gebauedeNeu->id;    
                    } else {
                        $gebauedeNeu = Gebaeude::create([
                            'bezeichnung' => $bue->name,
                            'zeichen' => '?',
                            'standort_id' => $standort_extern->id,
                            'strasse' => $bue->strasse.' '.$bue->hausnummer,
                            'ort' => $bue->ort,
                            'plz' => (int)$bue->plz,
                        ]);
                        $data['gebaeude_id'] = $gebauedeNeu->id;
                    }                    
                }
            }
            $dates['gueltig_ab'] = isset($data['gueltig_ab']) ? Carbon::parse($data['gueltig_ab']) : null;
            $dates['gueltig_bis'] = isset($data['gueltig_bis']) ? Carbon::parse($data['gueltig_bis']) : null;
            $dates['einheit_gueltig_ab'] = isset($data['einheit_gueltig_ab']) ? Carbon::parse($data['einheit_gueltig_ab']) : null;
            $dates['einheit_gueltig_bis'] = isset($data['einheit_gueltig_bis']) ? Carbon::parse($data['einheit_gueltig_bis']) : null;

        Raum::create([
            'bue_id' => $data['bue_id'],        
            'itexia_id' => $data['itexia_id'] ?? null,
            'gueltig_ab' => $dates['gueltig_ab'] ?? null,
            'gueltig_bis' => $dates['gueltig_bis'] ?? null,
            'kurzzeichen' => $data['kurzzeichen'] ?? null,
            'druckbezeichnung' => $data['druckbezeichnung'] ?? null,
            'raumnummer' => $data['raumnummer'] ?? null,
            'gebaeude_id' => $data['gebaeude_id'] ?? null,
            'gebaeude_extern' => $data['gebaeude_extern'] ?? null,
            'plaetze' => $data['plaetze'] ?? null,
            'plaetze_ff' => $data['plaetze_ff'] ?? null,
            'qm' => $data['qm'] ?? null,
            'strasse' => $data['strasse'] ?? null,
            'plz' => $data['plz'] ?? null,
            'ort' => $data['ort'] ?? null,
            'raumnr_neu' => $data['raumnr_neu'] ?? null,
            'raumnr_vorgaenger' => $data['raumnr_vorgaenger'] ?? null,
            'raumnr_nachfolger' => $data['raumnr_nachfolger'] ?? null,
            'fachbereich_id' => $data['fachbereich_id'] ?? null,
            'hpi_lfd_nr' => $data['hpi_lfd_nr'] ?? null,
            'hpi_anzahl_einheiten' => $data['hpi_anzahl_einheiten'] ?? null,
            'bemerkung' => $data['bemerkung'] ?? null,
            'einheit_gueltig_ab' => $dates['einheit_gueltig_ab'],
            'einheit_gueltig_bis' => $dates['einheit_gueltig_bis'] ?? null,
            'etage_id' => $data['etage_id'] ?? null,
            'pri_sek' => $data['pri_sek'] ?? null,

        ]);
        }
        $compares = BueItexiaIntegrationService::compareRaeumeFilter();
        foreach($compares as $match)
        {
            $raum = Raum::where('bue_id', (int)$match['bue_id'])->first();
            if($raum) {
                $raum->update([
                    'itexia_id' => $match['itexia_id'],
                ]);     
            }
            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('app_raumverwaltung_raums')) {
            DB::table('app_raumverwaltung_raums')->truncate();
        }     
    }
};
