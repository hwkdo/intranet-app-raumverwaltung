<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Gebaeude;
use Hwkdo\IntranetAppRaumverwaltung\Models\Standort;

it('kann ein Gebäude mit Standort erstellen', function () {
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

    expect($gebaeude)->toBeInstanceOf(Gebaeude::class)
        ->and($gebaeude->bezeichnung)->toBe('Hauptgebäude')
        ->and($gebaeude->standort_id)->toBe($standort->id)
        ->and($gebaeude->standort)->toBeInstanceOf(Standort::class)
        ->and($gebaeude->standort->kurz)->toBe('DO');
});

it('kann ein Gebäude aktualisieren', function () {
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

    $gebaeude->update(['bezeichnung' => 'Nebengebäude']);

    expect($gebaeude->fresh()->bezeichnung)->toBe('Nebengebäude');
});

it('kann ein Gebäude löschen', function () {
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

    $gebaeude->delete();

    expect(Gebaeude::find($gebaeude->id))->toBeNull();
});
