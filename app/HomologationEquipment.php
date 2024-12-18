<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomologationEquipment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function homologation()
    {
        return $this->belongsTo(Homologation::class, 'homologation_id');
    }
}
