<?php

namespace App\Models\Storage\Ticket;

use App\Models\Storage\Employee\Employee;
use App\Models\Storage\Ticket\References\TicketPriority;
use App\Models\Storage\Ticket\References\TicketStatus;
use App\Models\Storage\Ticket\References\TicketType;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    public function applicant()
    {
        return $this->belongsTo(Employee::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function type()
    {
        return $this->belongsTo(TicketType::class);
    }

    public function priority()
    {
        return $this->belongsTo(TicketPriority::class);
    }

    public function status()
    {
        return $this->belongsTo(TicketStatus::class);
    }

}
