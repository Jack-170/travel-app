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
        Schema::create('trips', function (Blueprint $table) {
            $table->id(); // Colonna auto-incrementante per l'ID
            $table->string('title'); // Titolo del viaggio
            $table->string('slug'); // Slug per URL o identificativo unico
            $table->string('destination'); // Destinazione del viaggio
            $table->date('leaving'); // Data di partenza
            $table->date('return'); // Data di ritorno
            $table->unsignedBigInteger('user_id')->nullable(); // Colonna user_id con chiave esterna, può essere null
            $table->timestamps(); // Colonne created_at e updated_at

            // Definizione del vincolo di chiave esterna
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete(); // Imposta a null il valore di user_id se il record dell'utente viene eliminato
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
        });


        Schema::dropIfExists('trips');
    }
};
