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
        Schema::create('stages', function (Blueprint $table) {
            $table->id(); // Colonna auto-incrementante per l'ID
            $table->string('title'); // Titolo del palcoscenico
            $table->string('slug'); // Slug per URL o identificativo unico
            $table->string('location'); // Localizzazione del palcoscenico
            $table->text('description')->nullable(); // Descrizione, può essere nulla
            $table->string('image')->nullable(); // Immagine, può essere nulla
            $table->boolean('completed')->default(false);
            $table->unsignedBigInteger('day_id')->nullable(); // Colonna day_id con chiave esterna, può essere nulla
            $table->timestamps(); // Colonne created_at e updated_at

            // Definizione del vincolo di chiave esterna
            $table->foreign('day_id')
                ->references('id')
                ->on('days')
                ->nullOnDelete(); // Imposta a null il valore di day_id se il record associato viene eliminato
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stages', function (Blueprint $table) {
            // Rimozione del vincolo di chiave esterna
            $table->dropForeign(['day_id']);
        });

        // Eliminazione della tabella stages
        Schema::dropIfExists('stages');
    }
};
