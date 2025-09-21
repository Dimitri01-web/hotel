<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécution de la migration.
     */
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id');  // Lien vers la réservation
            $table->decimal('montant', 10, 2);             // Montant payé
            $table->string('mode_paiement');               // Ex: espèces, carte, virement
            $table->date('date_paiement');                 // Date du paiement
            $table->string('reference')->nullable();       // Référence du paiement (optionnel)
            $table->timestamps();

            // Clé étrangère
            $table->foreign('reservation_id')
                  ->references('id')
                  ->on('reservations')
                  ->onDelete('cascade');
        });
    }

    /**
     * Annulation de la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
