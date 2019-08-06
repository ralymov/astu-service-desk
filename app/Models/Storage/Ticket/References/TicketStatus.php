<?php

namespace App\Models\Storage\Ticket\References;

use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{

    protected $guarded = ['id'];

    public const NEW = 'new';
    public const IN_PROGRESS = 'in_progress';
    public const SPECIFY = 'specify';
    public const DONE = 'done';
    public const CANCEL = 'cancel';

    public function scopeNew($query)
    {
        return $query->whereName('Новая');
    }

}
