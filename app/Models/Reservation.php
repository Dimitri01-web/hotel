<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['chambre_id', 'locataire_id', 'date_arrivee', 'date_depart', 'acompte', 'statut'];

    public function chambre()
    {
        return $this->belongsTo(Chambre::class);
    }

    public function locataire()
    {
        return $this->belongsTo(Locataire::class);
    }

    public function paiements()
{
    return $this->hasMany(Paiement::class);
}

}
