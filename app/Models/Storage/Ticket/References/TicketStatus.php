<?php

namespace App\Models\Storage\Ticket\References;

use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{

    protected $guarded = ['id'];

    public function scopeNew($query)
    {
        return $query->whereName('Новая');
    }

}
