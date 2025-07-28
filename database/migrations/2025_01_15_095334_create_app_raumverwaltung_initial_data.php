<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Etage;
use Hwkdo\IntranetAppRaumverwaltung\Models\Fachbereich;
use Hwkdo\IntranetAppRaumverwaltung\Models\Gebaeude;
use Hwkdo\IntranetAppRaumverwaltung\Models\Nutzungsart;
use Hwkdo\IntranetAppRaumverwaltung\Models\Standort;
use Hwkdo\IntranetAppBase\Helpers\Help;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Hwkdo\BueLaravel\BueLaravel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $standorts = [
            [
                'kurz' => 'BZA',
                'lang' => 'Ardeystraße, Dortmund',
                'nr' => 1,
                'zeichen' => 'A',
                'strasse' => 'Ardeystraße 93',
                'plz' => 44139,
                'ort' => 'Dortmund',
            ],
            [
                'kurz' => 'Reinoldi',
                'lang' => 'Reinoldistr, Dortmund',
                'nr' => 4,
                'zeichen' => 'R',
                'strasse' => 'Reinoldistraße 7-9',
                'plz' => 44135,
                'ort' => 'Dortmund',
            ],
            [
                'kurz' => 'BZH',
                'lang' => 'Hansemann',
                'nr' => 5,
                'zeichen' => 'H',
                'strasse' => 'Barbarastraße 7',
                'plz' => 44357,
                'ort' => 'Dortmund',
            ],
            [
                'kurz' => 'BZK',
                'lang' => 'Körne',
                'nr' => 6,
                'zeichen' => 'K',
                'strasse' => 'Lange Reihe 62',
                'plz' => 44143,
                'ort' => 'Dortmund',
            ],
            [
                'kurz' => 'BZR',
                'lang' => 'Bochum',
                'nr' => 7,
                'zeichen' => 'B',
                'strasse' => 'Springorumallee 10',
                'plz' => 44795,
                'ort' => 'Bochum',
            ],
            [
                'kurz' => 'BZS',
                'lang' => 'Soest',
                'nr' => 8,
                'zeichen' => 'S',
                'strasse' => 'Am Handwerk 4',
                'plz' => 59494,
                'ort' => 'Soest',
            ],
            [
                'kurz' => 'HoheStr',
                'lang' => 'Internat Hohe Straße, Dortmund',
                'nr' => 10,
                'zeichen' => 'A',
                'strasse' => 'Hohe Straße 141',
                'plz' => 44139,
                'ort' => 'Dortmund',
            ],
            [
                'kurz' => 'EXT',
                'lang' => 'Extern (angemietet, aber nicht von einer Kreishandwerkerschaft)',
                'nr' => 99,
                'zeichen' => 'E',
                'strasse' => 'Hohe Straße 141',
                'plz' => 44139,
                'ort' => 'Dortmund',
            ],
        ];
        foreach($standorts as $standort) {
            Standort::create([
                'kurz' => $standort['kurz'],
                'lang' => $standort['lang'],
                'nr' => $standort['nr'],
                'zeichen' => $standort['zeichen'],
                'strasse' => $standort['strasse'],
                'plz' => $standort['plz'],
                'ort' => $standort['ort'],
            ]);
        }


        $standort_bza = Standort::where('kurz', 'BZA')->first();
        $standort_soest = Standort::where('kurz', 'BZS')->first();
        $standort_ruhr = Standort::where('kurz', 'BZR')->first();
        $standort_koerne = Standort::where('kurz', 'BZK')->first();
        $standort_bzh = Standort::where('kurz', 'BZH')->first();
        $standort_reinoldi = Standort::where('kurz', 'Reinoldi')->first();
        $standort_ihs = Standort::where('kurz', 'HoheStr')->first();
        $standort_extern = Standort::where('kurz', 'EXT')->first();

        $gebaeudes = [
            [
                'bezeichnung' => 'Extern (Hauptgebäude)',
                'zeichen' => 'E',
                'standort_id' => $standort_extern->id,
            ],
            [
                'bezeichnung' => 'Reinoldi (Hauptgebäude)',
                'zeichen' => 'R',
                'standort_id' => $standort_reinoldi->id,
            ],
            [
                'bezeichnung' => 'HoheStr (Hauptgebäude)',
                'zeichen' => 'H',
                'standort_id' => $standort_ihs->id,
            ],
            [
                'bezeichnung' => 'Verwaltung (Torbogen)',
                'zeichen' => 'V',
                'standort_id' => $standort_bzh->id,
            ],
            [
                'bezeichnung' => 'Zweirad',
                'zeichen' => 'Z',
                'standort_id' => $standort_bzh->id,
            ],
            [
                'bezeichnung' => 'Seminar',
                'zeichen' => 'S',
                'standort_id' => $standort_bzh->id,
            ],
            [
                'bezeichnung' => 'Kaue',
                'zeichen' => 'K',
                'standort_id' => $standort_bzh->id,
            ],
            [
                'bezeichnung' => 'Maschinenhalle',
                'zeichen' => 'M',
                'standort_id' => $standort_bzh->id,
            ],
            [
                'bezeichnung' => 'Kirche',
                'zeichen' => 'K',
                'standort_id' => $standort_bzh->id,
            ],            
            [
                'bezeichnung' => 'Geb A (Turm)',
                'zeichen' => 'A',
                'standort_id' => $standort_koerne->id,
            ],
            [
                'bezeichnung' => 'Geb (Az)Bau',
                'zeichen' => 'B',
                'standort_id' => $standort_koerne->id,
            ],
            [
                'bezeichnung' => 'Geb Maler',
                'zeichen' => 'M',
                'standort_id' => $standort_koerne->id,
                'strasse' => 'Lange Reihe 71',
                'ort' => 'Dortmund',
                'plz' => 44143,
            ],
            [
                'bezeichnung' => 'Geb Reiniger',
                'zeichen' => 'G',
                'standort_id' => $standort_koerne->id,
                'strasse' => 'Lange Reihe 71',
                'ort' => 'Dortmund',
                'plz' => 44143,
            ],
            [
                'bezeichnung' => 'Geb Friseure',
                'zeichen' => 'F',
                'standort_id' => $standort_koerne->id,
                'strasse' => 'Lange Reihe 64',
                'ort' => 'Dortmund',
                'plz' => 44143,
            ],
            [
                'bezeichnung' => 'Gebäudeteil A',
                'zeichen' => '1',
                'standort_id' => $standort_ruhr->id,
            ],
            [
                'bezeichnung' => 'Gebäudeteil B',
                'zeichen' => '2',
                'standort_id' => $standort_ruhr->id,
            ],
            [
                'bezeichnung' => 'Gebäudeteil C',
                'zeichen' => '3',
                'standort_id' => $standort_ruhr->id,
            ],
            [
                'bezeichnung' => 'Gebäudeteil D',
                'zeichen' => '4',
                'standort_id' => $standort_ruhr->id,
            ],
            [
                'bezeichnung' => 'Gebäudeteil E',
                'zeichen' => '5',
                'standort_id' => $standort_ruhr->id,
            ],
            [
                'bezeichnung' => 'Gebäudeteil F',
                'zeichen' => '',
                'standort_id' => $standort_ruhr->id,
            ],
            [
                'bezeichnung' => 'Haus A',
                'zeichen' => 'A',
                'standort_id' => $standort_bza->id,
            ],
            [
                'bezeichnung' => 'Haus 1',
                'zeichen' => '1',
                'standort_id' => $standort_bza->id,
            ],
            [
                'bezeichnung' => 'Haus 2',
                'zeichen' => '2',
                'standort_id' => $standort_bza->id,
            ],
            [
                'bezeichnung' => 'Haus 3',
                'zeichen' => '3',
                'standort_id' => $standort_bza->id,
            ],
            [
                'bezeichnung' => 'Haus 4',
                'zeichen' => '4',
                'standort_id' => $standort_bza->id,
            ],
            [
                'bezeichnung' => 'Verwaltung / Gr. Forum',
                'zeichen' => 'A',
                'standort_id' => $standort_soest->id,
            ],
            [
                'bezeichnung' => 'Halle 1',
                'zeichen' => '1',
                'standort_id' => $standort_soest->id,
            ],
            [
                'bezeichnung' => 'Halle 2',
                'zeichen' => '2',
                'standort_id' => $standort_soest->id,
            ],
            [
                'bezeichnung' => 'Halle 3',
                'zeichen' => '3',
                'standort_id' => $standort_soest->id,
            ],

        ];
        foreach($gebaeudes as $gebaeude) {
            Gebaeude::create([
                'bezeichnung' => $gebaeude['bezeichnung'],
                'zeichen' => $gebaeude['zeichen'],
                'standort_id' => $gebaeude['standort_id'],
                'strasse' => $gebaeude['strasse'] ?? null,
                'plz' => $gebaeude['plz'] ?? null,
                'ort' => $gebaeude['ort'] ?? null,
            ]);
        }

        $etages = [
            [
                'bezeichnung' => 'Erdgeschoß',
                'zeichen' => '0',
            ],
            [
                'bezeichnung' => '1. OG',
                'zeichen' => '1',
            ],
            [
                'bezeichnung' => '2. OG',
                'zeichen' => '2',
            ],
            [
                'bezeichnung' => '3. OG',
                'zeichen' => '3',
            ],
            [
                'bezeichnung' => '4. OG',
                'zeichen' => '4',
            ],
            [
                'bezeichnung' => '5.OG',
                'zeichen' => '5',
            ],
            [
                'bezeichnung' => 'Kellergeschoß',
                'zeichen' => '9',
            ],
        ];
        foreach($etages as $etage) {
            Etage::create([
                'bezeichnung' => $etage['bezeichnung'],
                'zeichen' => $etage['zeichen'],            
            ]);
        }

        $nutzungs = [
            [
                'bezeichnung' => 'Freiflaeche',
                'bezeichnung_lang' => 'Freiflächen-/ Außenbereich',
                'raumart' => 'schulung',
                'zeichen' => 'F',
            ],
            [
                'bezeichnung' => 'Theorie/EDV',
                'bezeichnung_lang' => 'Theorie (inkl. EDV-Schulungsraum, Zeichensaal, Prüfungsraum)',
                'raumart' => 'schulung',
                'zeichen' => 'T',
            ],
            [
                'bezeichnung' => 'Werkstatt',
                'bezeichnung_lang' => 'Werkstatt',
                'raumart' => 'schulung',
                'zeichen' => 'W',
            ],
            [
                'bezeichnung' => 'Büro',
                'bezeichnung_lang' => 'Büro',
                'raumart' => 'verwaltung',
                'zeichen' => 'B',
            ],
            [
                'bezeichnung' => 'Lager',
                'bezeichnung_lang' => 'Lager (Schulungsmaterial, Gebäudereinigungsmittel ...)',
                'raumart' => 'verwaltung',
                'zeichen' => 'L',                
            ],
            [
                'bezeichnung' => 'Flur',
                'bezeichnung_lang' => 'Erschließungsflächen (Flur / Treppenhaus)',
                'raumart' => 'verwaltung',
                'zeichen' => 'E',                
            ],
            [
                'bezeichnung' => 'Toilette',
                'bezeichnung_lang' => 'Sanitär / Umkleide / Sanitätsraum',
                'raumart' => 'verwaltung',
                'zeichen' => 'S',                
            ],
            [
                'bezeichnung' => 'Haustechnik',
                'bezeichnung_lang' => 'Gebäudetechnik (Heizung, Lüftung, Aufzug …)',
                'raumart' => 'verwaltung',
                'zeichen' => 'G',                
            ],
            [
                'bezeichnung' => 'Besprechungsraum',
                'bezeichnung_lang' => 'Veranstaltungs- / Besprechungsraum (inkl. Kaue, Vortragssaal, Bistro …)',
                'raumart' => 'verwaltung',
                'zeichen' => 'V',                
            ],
            [
                'bezeichnung' => 'Küche',
                'bezeichnung_lang' => 'Kantine / Küche / Kiosk (inkl. Teeküche)',
                'raumart' => 'verwaltung',
                'zeichen' => 'K',                
            ],
            
        ];
        foreach($nutzungs as $nutzung) {
            Nutzungsart::create([
                'bezeichnung' => $nutzung['bezeichnung'],
                'bezeichnung_lang' => $nutzung['bezeichnung_lang'],
                'zeichen' => $nutzung['zeichen'],
                'raumart' => $nutzung['raumart'],            
            ]);
        }

        foreach(app(BueLaravel::class)->getFachbereiche() as $fb) {
            Fachbereich::create([
                'nr' => (int)$fb->id,
                'bezeichnung' => $fb->name,
                'kst' => (int)$fb->kst,
            ]);
        }        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        DB::table('app_raumverwaltung_standorts')->truncate();
        DB::table('app_raumverwaltung_gebaeudes')->truncate();
        DB::table('app_raumverwaltung_nutzungsarts')->truncate();
        DB::table('app_raumverwaltung_fachbereichs')->truncate();
        DB::table('app_raumverwaltung_etages')->truncate();
    }
};
