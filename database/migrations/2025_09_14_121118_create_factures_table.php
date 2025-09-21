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

        Schema::create('factures', function (Blueprint $table) {
            $table->id();

            // Lien vers le paiement
            $table->foreignId('paiement_id')
                  ->constrained('paiements')
                  ->onDelete('cascade');

            // Lien vers la réservation
            $table->foreignId('reservation_id')
                  ->constrained('reservations')
                  ->onDelete('cascade');

            // Montants
            $table->decimal('montant_total', 10, 2);   // prix total du séjour
            $table->decimal('montant_paye', 10, 2);    // total payé (acompte + paiements)
            $table->decimal('reste', 10, 2);           // reste à payer

            // Date de facture
            $table->date('date_facture');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
