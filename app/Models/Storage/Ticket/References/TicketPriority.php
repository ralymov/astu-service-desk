<?php

namespace App\Models\Storage\Ticket\References;

use Illuminate\Database\Eloquent\Model;

class TicketPriority extends Model
{

    public const LOW = 'low';
    public const NORMAL = 'normal';
    public const HIGH = 'high';

    protected $guarded = ['id'];

}
