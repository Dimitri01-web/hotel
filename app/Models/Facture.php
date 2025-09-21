<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = [
        'paiement_id',
        'reservation_id',
        'montant_total',
        'montant_paye',
        'reste',
        'date_facture',
    ];

    /**
     * La facture appartient à un paiement
     */
    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }

    /**
     * La facture est liée à une réservation
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
