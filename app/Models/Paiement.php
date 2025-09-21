<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'reservation_id',
        'montant',
        'mode_paiement',
        'date_paiement',
        'reference',
    ];

    /**
     * Relation avec la réservation.
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Relation avec la facture (si une facture est générée).
     */
    public function facture()
    {
        return $this->hasOne(Facture::class);
    }
}
