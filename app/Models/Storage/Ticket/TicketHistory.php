<?php

namespace App\Models\Storage\Ticket;

use App\Models\Storage\User\User;
use App\Traits\FormatDateTrait;
use Illuminate\Database\Eloquent\Model;

class TicketHistory extends Model
{
    use FormatDateTrait;

    protected $guarded = ['id'];
    protected $table = 'ticket_history';

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

}
