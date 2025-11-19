<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Tests\Feature;

use Hwkdo\IntranetAppRaumverwaltung\Models\Etage;
use Hwkdo\IntranetAppRaumverwaltung\Models\Gebaeude;
use Hwkdo\IntranetAppRaumverwaltung\Models\Nutzungsart;
use Hwkdo\IntranetAppRaumverwaltung\Models\Raum;
use Hwkdo\IntranetAppRaumverwaltung\Models\Standort;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RaumEventListenersTest extends TestCase
{
    use RefreshDatabase;

    protected function createTestData()
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

        return compact('standort', 'gebaeude', 'etage', 'nutzungsart');
    }

    public function test_gebaeude_update_triggers_raumnr_update(): void
    {
        $data = $this->createTestData();

        $raum = Raum::create([
            'lfd_nr' => 5,
            'gebaeude_id' => $data['gebaeude']->id,
            'etage_id' => $data['etage']->id,
            'nutzungsart_id' => $data['nutzungsart']->id,
            'raumnr_neu' => Raum::generateNumber($data['gebaeude']->id, $data['etage']->id, $data['nutzungsart']->id, 5),
        ]);

        expect($raum->raumnr_neu)->toBe('DO-UR-A205');

        // Gebäude Zeichen ändern
        $data['gebaeude']->update(['zeichen' => 'B']);

        $raum->refresh();
        expect($raum->raumnr_neu)->toBe('DO-UR-B205');
    }

    public function test_etage_update_triggers_raumnr_update(): void
    {
        $data = $this->createTestData();

        $raum = Raum::create([
            'lfd_nr' => 5,
            'gebaeude_id' => $data['gebaeude']->id,
            'etage_id' => $data['etage']->id,
            'nutzungsart_id' => $data['nutzungsart']->id,
            'raumnr_neu' => Raum::generateNumber($data['gebaeude']->id, $data['etage']->id, $data['nutzungsart']->id, 5),
        ]);

        expect($raum->raumnr_neu)->toBe('DO-UR-A205');

        // Etage Zeichen ändern
        $data['etage']->update(['zeichen' => '3']);

        $raum->refresh();
        expect($raum->raumnr_neu)->toBe('DO-UR-A305');
    }

    public function test_nutzungsart_update_triggers_raumnr_update(): void
    {
        $data = $this->createTestData();

        $raum = Raum::create([
            'lfd_nr' => 5,
            'gebaeude_id' => $data['gebaeude']->id,
            'etage_id' => $data['etage']->id,
            'nutzungsart_id' => $data['nutzungsart']->id,
            'raumnr_neu' => Raum::generateNumber($data['gebaeude']->id, $data['etage']->id, $data['nutzungsart']->id, 5),
        ]);

        expect($raum->raumnr_neu)->toBe('DO-UR-A205');

        // Nutzungsart Zeichen ändern
        $data['nutzungsart']->update(['zeichen' => 'BU']);

        $raum->refresh();
        expect($raum->raumnr_neu)->toBe('DO-BU-A205');
    }
}

