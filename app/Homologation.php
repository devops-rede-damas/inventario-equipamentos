<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Homologation extends Model
{
    protected $fillable = [
        'homologation_name',
        'homologation_date_initial',
        'homologation_date_final',
        'homologation_status',
    ];

    public function homologationEquipments()
    {
        return $this->hasMany(HomologationEquipment::class);
    }
}
