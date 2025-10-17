<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Etage;
use Hwkdo\IntranetAppRaumverwaltung\Models\Fachbereich;
use Hwkdo\IntranetAppRaumverwaltung\Models\Gebaeude;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_raumverwaltung_raums', function (Blueprint $table) {
            $table->id();
            $table->integer('bue_id')->nullable();
            $table->integer('itexia_id')->nullable();
            $table->date('gueltig_ab')->nullable();
            $table->date('gueltig_bis')->nullable();
            $table->string('kurzzeichen')->nullable();
            $table->string('druckbezeichnung')->nullable();
            $table->string('raumnummer')->nullable();
            $table->foreignIdFor(Gebaeude::class)->nullable();
            $table->string('gebaeude_extern')->nullable();
            $table->integer('plaetze')->nullable();
            $table->integer('plaetze_ff')->nullable();
            $table->float('qm', precision: 2)->nullable();
            $table->string('strasse')->nullable();
            $table->integer('plz')->nullable();
            $table->string('ort')->nullable();
            $table->string('raumnr_neu')->nullable();
            $table->string('raumnr_vorgaenger')->nullable();
            $table->string('raumnr_nachfolger')->nullable();
            $table->foreignIdFor(Fachbereich::class)->nullable();
            $table->integer('hpi_lfd_nr')->nullable();
            $table->integer('hpi_anzahl_einheiten')->nullable();
            $table->text('bemerkung')->nullable();
            $table->date('einheit_gueltig_ab')->nullable();
            $table->date('einheit_gueltig_bis')->nullable();
            $table->foreignIdFor(Etage::class)->nullable();
            $table->string('pri_sek')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_raumverwaltung_raums');
    }
};
