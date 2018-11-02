<?php

namespace App\Models\Storage\Ticket;

use App\Models\Storage\Employee\Employee;
use App\Models\Storage\Employee\Location;
use App\Models\Storage\Ticket\References\TicketPriority;
use App\Models\Storage\Ticket\References\TicketStatus;
use App\Models\Storage\Ticket\References\TicketType;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->status_id = TicketStatus::new()->first()->id ?? null;
        });

    }

    #region Relations

    public function forList()
    {
        return $this->load('applicant_location', 'applicant', 'employee', 'type', 'priority', 'status');
    }

    public function scopeForList($query)
    {
        return $query->with('applicant_location', 'applicant', 'employee', 'type', 'priority', 'status');
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'ticket_comments');
    }

    public function applicant_location()
    {
        return $this->belongsTo(Location::class);
    }

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

    #endregion

}
