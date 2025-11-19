<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Tests\Feature;

use App\Models\User;
use Hwkdo\IntranetAppRaumverwaltung\Models\Etage;
use Hwkdo\IntranetAppRaumverwaltung\Models\Gebaeude;
use Hwkdo\IntranetAppRaumverwaltung\Models\Nutzungsart;
use Hwkdo\IntranetAppRaumverwaltung\Models\Raum;
use Hwkdo\IntranetAppRaumverwaltung\Models\Standort;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RaumCrudTest extends TestCase
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

    public function test_raum_can_be_created_with_automatic_raumnr_neu(): void
    {
        $data = $this->createTestData();

        $raum = Raum::create([
            'lfd_nr' => 5,
            'gebaeude_id' => $data['gebaeude']->id,
            'etage_id' => $data['etage']->id,
            'nutzungsart_id' => $data['nutzungsart']->id,
            'raumnr_neu' => Raum::generateNumber($data['gebaeude']->id, $data['etage']->id, $data['nutzungsart']->id, 5),
        ]);

        expect($raum->exists())->toBeTrue()
            ->and($raum->raumnr_neu)->toBe('DO-UR-A205');
    }

    public function test_raum_can_be_updated(): void
    {
        $data = $this->createTestData();

        $raum = Raum::create([
            'lfd_nr' => 5,
            'gebaeude_id' => $data['gebaeude']->id,
            'etage_id' => $data['etage']->id,
            'nutzungsart_id' => $data['nutzungsart']->id,
            'raumnr_neu' => Raum::generateNumber($data['gebaeude']->id, $data['etage']->id, $data['nutzungsart']->id, 5),
            'druckbezeichnung' => 'Alter Name',
        ]);

        $raum->update(['druckbezeichnung' => 'Neuer Name']);

        expect($raum->fresh()->druckbezeichnung)->toBe('Neuer Name');
    }

    public function test_raum_can_be_soft_deleted(): void
    {
        $data = $this->createTestData();

        $raum = Raum::create([
            'lfd_nr' => 5,
            'gebaeude_id' => $data['gebaeude']->id,
            'etage_id' => $data['etage']->id,
            'nutzungsart_id' => $data['nutzungsart']->id,
            'raumnr_neu' => Raum::generateNumber($data['gebaeude']->id, $data['etage']->id, $data['nutzungsart']->id, 5),
        ]);

        $raum->delete();

        expect(Raum::find($raum->id))->toBeNull()
            ->and(Raum::withTrashed()->find($raum->id))->not->toBeNull();
    }

    public function test_raum_can_be_restored_after_soft_delete(): void
    {
        $data = $this->createTestData();

        $raum = Raum::create([
            'lfd_nr' => 5,
            'gebaeude_id' => $data['gebaeude']->id,
            'etage_id' => $data['etage']->id,
            'nutzungsart_id' => $data['nutzungsart']->id,
            'raumnr_neu' => Raum::generateNumber($data['gebaeude']->id, $data['etage']->id, $data['nutzungsart']->id, 5),
        ]);

        $raum->delete();
        $raum->restore();

        expect(Raum::find($raum->id))->not->toBeNull();
    }

    public function test_raum_relationships_work_correctly(): void
    {
        $data = $this->createTestData();

        $raum = Raum::create([
            'lfd_nr' => 5,
            'gebaeude_id' => $data['gebaeude']->id,
            'etage_id' => $data['etage']->id,
            'nutzungsart_id' => $data['nutzungsart']->id,
            'raumnr_neu' => Raum::generateNumber($data['gebaeude']->id, $data['etage']->id, $data['nutzungsart']->id, 5),
        ]);

        expect($raum->gebaeude->id)->toBe($data['gebaeude']->id)
            ->and($raum->etage->id)->toBe($data['etage']->id)
            ->and($raum->nutzungsart->id)->toBe($data['nutzungsart']->id)
            ->and($raum->gebaeude->standort->id)->toBe($data['standort']->id);
    }
}

