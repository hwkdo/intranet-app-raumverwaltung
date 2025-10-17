<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Standort;

it('kann einen Standort erstellen', function () {
    $data = [
        'kurz' => 'DO',
        'lang' => 'Dortmund',
        'nr' => 1,
        'zeichen' => 'DO',
        'strasse' => 'Musterstraße 1',
        'plz' => 44135,
        'ort' => 'Dortmund',
    ];

    $standort = Standort::create($data);

    expect($standort)->toBeInstanceOf(Standort::class)
        ->and($standort->kurz)->toBe('DO')
        ->and($standort->lang)->toBe('Dortmund');
});

it('kann einen Standort aktualisieren', function () {
    $standort = Standort::create([
        'kurz' => 'DO',
        'lang' => 'Dortmund',
        'nr' => 1,
        'zeichen' => 'DO',
        'strasse' => 'Musterstraße 1',
        'plz' => 44135,
        'ort' => 'Dortmund',
    ]);

    $standort->update(['kurz' => 'DO2']);

    expect($standort->fresh()->kurz)->toBe('DO2');
});

it('kann einen Standort löschen', function () {
    $standort = Standort::create([
        'kurz' => 'DO',
        'lang' => 'Dortmund',
        'nr' => 1,
        'zeichen' => 'DO',
        'strasse' => 'Musterstraße 1',
        'plz' => 44135,
        'ort' => 'Dortmund',
    ]);

    $standort->delete();

    expect(Standort::find($standort->id))->toBeNull();
});
