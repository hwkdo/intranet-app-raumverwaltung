<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Tests\Unit;

use Hwkdo\IntranetAppRaumverwaltung\Models\Etage;
use Hwkdo\IntranetAppRaumverwaltung\Models\Gebaeude;
use Hwkdo\IntranetAppRaumverwaltung\Models\Nutzungsart;
use Hwkdo\IntranetAppRaumverwaltung\Models\Raum;
use Hwkdo\IntranetAppRaumverwaltung\Models\Standort;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RaumnummerGenerierungTest extends TestCase
{
    use RefreshDatabase;

    public function test_generates_correct_raumnummer_format(): void
    {
        $standort = Standort::create([
            'kurz' => 'DO',
            'lang' => 'Dortmund',
            'nr' => 1,
            'zeichen' => 'DO',
            'strasse' => 'Teststraße 1',
            'plz' => 44139,
            'ort' => 'Dortmund',
        ]);

        $gebaeude = Gebaeude::create([
            'bezeichnung' => 'Gebäude A',
            'zeichen' => 'A',
            'standort_id' => $standort->id,
        ]);

        $etage = Etage::create([
            'bezeichnung' => 'Etage 2',
            'zeichen' => '2',
        ]);

        $nutzungsart = Nutzungsart::create([
            'bezeichnung' => 'Unterrichtsraum',
            'bezeichnung_lang' => 'Unterrichtsraum',
            'zeichen' => 'UR',
            'raumart' => 'schulung',
        ]);

        $nummer = Raum::generateNumber($gebaeude->id, $etage->id, $nutzungsart->id, 5);

        expect($nummer)->toBe('DO-UR-A205');
    }

    public function test_generates_raumnummer_with_leading_zero(): void
    {
        $standort = Standort::create([
            'kurz' => 'BO',
            'lang' => 'Bochum',
            'nr' => 2,
            'zeichen' => 'BO',
            'strasse' => 'Teststraße 2',
            'plz' => 44789,
            'ort' => 'Bochum',
        ]);

        $gebaeude = Gebaeude::create([
            'bezeichnung' => 'Gebäude B',
            'zeichen' => 'B',
            'standort_id' => $standort->id,
        ]);

        $etage = Etage::create([
            'bezeichnung' => 'Erdgeschoss',
            'zeichen' => '0',
        ]);

        $nutzungsart = Nutzungsart::create([
            'bezeichnung' => 'Büro',
            'bezeichnung_lang' => 'Büro',
            'zeichen' => 'BU',
            'raumart' => 'verwaltung',
        ]);

        $nummer = Raum::generateNumber($gebaeude->id, $etage->id, $nutzungsart->id, 3);

        expect($nummer)->toBe('BO-BU-B003');
    }

    public function test_generate_my_number_returns_null_when_fields_missing(): void
    {
        $raum = new Raum();
        $raum->gebaeude_id = 1;
        $raum->etage_id = 1;
        // nutzungsart_id fehlt

        expect($raum->generateMyNumber())->toBeNull();
    }

    public function test_generate_my_number_returns_correct_number(): void
    {
        $standort = Standort::create([
            'kurz' => 'ES',
            'lang' => 'Essen',
            'nr' => 3,
            'zeichen' => 'ES',
            'strasse' => 'Teststraße 3',
            'plz' => 45127,
            'ort' => 'Essen',
        ]);

        $gebaeude = Gebaeude::create([
            'bezeichnung' => 'Gebäude C',
            'zeichen' => 'C',
            'standort_id' => $standort->id,
        ]);

        $etage = Etage::create([
            'bezeichnung' => 'Etage 1',
            'zeichen' => '1',
        ]);

        $nutzungsart = Nutzungsart::create([
            'bezeichnung' => 'Lager',
            'bezeichnung_lang' => 'Lager',
            'zeichen' => 'LA',
            'raumart' => 'verwaltung',
        ]);

        $raum = new Raum();
        $raum->gebaeude_id = $gebaeude->id;
        $raum->etage_id = $etage->id;
        $raum->nutzungsart_id = $nutzungsart->id;
        $raum->lfd_nr = 12;

        expect($raum->generateMyNumber())->toBe('ES-LA-C112');
    }
}

