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
        Schema::create('chambres', function (Blueprint $table) {
        $table->id();
        $table->string('numero')->unique();
        $table->enum('type', ['simple', 'double', 'suite']);
        $table->decimal('prix', 8, 2);
        $table->enum('etat', ['libre', 'occupée', 'en nettoyage'])->default('libre');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chambres');
    }
};
