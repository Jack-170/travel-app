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
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('location');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('completed')->default(false);
            $table->unsignedBigInteger('day_id')->nullable();
            $table->timestamps();

            $table->foreign('day_id')
                ->references('id')
                ->on('days')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stages', function (Blueprint $table) {
            $table->dropForeign(['day_id']);
        });

        Schema::dropIfExists('stages');
    }
};
