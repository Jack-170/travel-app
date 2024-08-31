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
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->timestamps();


            $table->foreign('trip_id')
                ->references('id')
                ->on('trips')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('days', function (Blueprint $table) {

            $table->dropForeign(['trip_id']);
        });


        Schema::dropIfExists('days');
    }
};
