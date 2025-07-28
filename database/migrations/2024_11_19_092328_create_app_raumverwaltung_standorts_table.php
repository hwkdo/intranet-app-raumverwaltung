<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_raumverwaltung_standorts', function (Blueprint $table) {
            $table->id();
            $table->string('kurz');
            $table->string('lang');
            $table->integer('nr');
            $table->string('zeichen');
            $table->string('strasse');
            $table->integer('plz');
            $table->string('ort');
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_raumverwaltung_standorts');
    }
};
