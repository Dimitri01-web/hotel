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
        Schema::create('reservations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('chambre_id')->constrained()->onDelete('cascade');
        $table->foreignId('locataire_id')->constrained()->onDelete('cascade');
        $table->date('date_arrivee');
        $table->date('date_depart');
        $table->enum('statut', ['confirmée', 'en cours', 'terminée', 'annulée'])->default('confirmée');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
