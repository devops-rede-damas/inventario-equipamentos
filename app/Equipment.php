<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    protected $fillable = [
        'type',
        'cod_equipment',
        'location',
        'antivirus',
        'status',
        'partnumber',
        'locado',
        'description',
        'answerable'
    ];

    public function homologationEquipments(): HasMany
    {
        return $this->hasMany(HomologationEquipment::class);
    }
}
