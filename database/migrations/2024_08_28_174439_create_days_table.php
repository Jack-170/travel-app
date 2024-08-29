<?php

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
        Schema::create('days', function (Blueprint $table) {
            $table->id(); // Colonna auto-incrementante per l'ID
            $table->date('date'); // Data del giorno
            $table->unsignedBigInteger('trip_id')->nullable(); // Colonna jurney_id con chiave esterna, può essere null
            $table->timestamps(); // Colonne created_at e updated_at

            // Definizione del vincolo di chiave esterna
            $table->foreign('trip_id')
                ->references('id')
                ->on('trips') // Modifica questo se il nome della tabella è diverso (es. trips)
                ->nullOnDelete(); // Imposta a null il valore di jurney_id se il record associato viene eliminato
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('days', function (Blueprint $table) {
            // Rimozione del vincolo di chiave esterna
            $table->dropForeign(['trip_id']);
        });

        // Eliminazione della tabella days
        Schema::dropIfExists('days');
    }
};
