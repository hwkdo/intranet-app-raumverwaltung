<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Etage;
use Hwkdo\IntranetAppRaumverwaltung\Models\Fachbereich;
use Hwkdo\IntranetAppRaumverwaltung\Models\Gebaeude;
use Hwkdo\IntranetAppRaumverwaltung\Models\Nutzungsart;
use Hwkdo\IntranetAppRaumverwaltung\Models\Raum;
use Hwkdo\IntranetAppRaumverwaltung\Models\Standort;

it('kann einen Raum mit allen Beziehungen erstellen', function () {
    $standort = Standort::create([
        'kurz' => 'DO',
        'lang' => 'Dortmund',
        'nr' => 1,
        'zeichen' => 'DO',
        'strasse' => 'Musterstraße 1',
        'plz' => 44135,
        'ort' => 'Dortmund',
    ]);

    $gebaeude = Gebaeude::create([
        'bezeichnung' => 'Hauptgebäude',
        'zeichen' => 'HG',
        'standort_id' => $standort->id,
    ]);

    $etage = Etage::create([
        'bezeichnung' => '1. Etage',
        'zeichen' => '1',
    ]);

    $nutzungsart = Nutzungsart::create([
        'bezeichnung' => 'Schulungsraum',
        'bezeichnung_lang' => 'Schulungsraum',
        'zeichen' => 'SR',
        'raumart' => 'schulung',
    ]);

    $fachbereich = Fachbereich::create([
        'nr' => 1,
        'bezeichnung' => 'IT',
        'kst' => 1000,
    ]);

    $raum = Raum::create([
        'raumnummer' => '101',
        'gebaeude_id' => $gebaeude->id,
        'etage_id' => $etage->id,
        'nutzungsart_id' => $nutzungsart->id,
        'fachbereich_id' => $fachbereich->id,
        'qm' => 50.5,
        'plaetze' => 20,
    ]);

    expect($raum)->toBeInstanceOf(Raum::class)
        ->and($raum->raumnummer)->toBe('101')
        ->and($raum->gebaeude)->toBeInstanceOf(Gebaeude::class)
        ->and($raum->etage)->toBeInstanceOf(Etage::class)
        ->and($raum->nutzungsart)->toBeInstanceOf(Nutzungsart::class)
        ->and($raum->fachbereich)->toBeInstanceOf(Fachbereich::class);
});

it('kann einen Raum aktualisieren', function () {
    $standort = Standort::create([
        'kurz' => 'DO',
        'lang' => 'Dortmund',
        'nr' => 1,
        'zeichen' => 'DO',
        'strasse' => 'Musterstraße 1',
        'plz' => 44135,
        'ort' => 'Dortmund',
    ]);

    $gebaeude = Gebaeude::create([
        'bezeichnung' => 'Hauptgebäude',
        'zeichen' => 'HG',
        'standort_id' => $standort->id,
    ]);

    $raum = Raum::create([
        'raumnummer' => '101',
        'gebaeude_id' => $gebaeude->id,
        'qm' => 50.5,
    ]);

    $raum->update(['raumnummer' => '102']);

    expect($raum->fresh()->raumnummer)->toBe('102');
});

it('kann einen Raum löschen', function () {
    $standort = Standort::create([
        'kurz' => 'DO',
        'lang' => 'Dortmund',
        'nr' => 1,
        'zeichen' => 'DO',
        'strasse' => 'Musterstraße 1',
        'plz' => 44135,
        'ort' => 'Dortmund',
    ]);

    $gebaeude = Gebaeude::create([
        'bezeichnung' => 'Hauptgebäude',
        'zeichen' => 'HG',
        'standort_id' => $standort->id,
    ]);

    $raum = Raum::create([
        'raumnummer' => '101',
        'gebaeude_id' => $gebaeude->id,
    ]);

    $raum->delete();

    expect(Raum::withTrashed()->find($raum->id))->not->toBeNull()
        ->and(Raum::find($raum->id))->toBeNull();
});
