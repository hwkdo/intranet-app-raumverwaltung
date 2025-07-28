<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Standort;
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
        Schema::create('app_raumverwaltung_gebaeudes', function (Blueprint $table) {
            $table->id();
            $table->string('bezeichnung');   
            $table->string('zeichen');
            $table->string('strasse')->nullable();
            $table->integer('plz')->nullable();
            $table->string('ort')->nullable();
            $table->foreignIdFor(Standort::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_raumverwaltung_gebaeudes');
    }
};
