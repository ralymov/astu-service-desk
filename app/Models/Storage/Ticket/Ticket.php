<?php

namespace App\Models\Storage\Ticket;

use App\Models\Storage\Employee\Employee;
use App\Models\Storage\Employee\Location;
use App\Models\Storage\Ticket\References\TicketPriority;
use App\Models\Storage\Ticket\References\TicketStatus;
use App\Models\Storage\Ticket\References\TicketType;
use App\Models\Storage\User\User;
use App\Traits\FormatDateTrait;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use FormatDateTrait;

    protected $guarded = ['id'];
    private $relationsForList = [
        'applicant_location',
        'applicant', 'contractor',
        'type',
        'priority',
        'status'
    ];
    private $relationsForEdit = [
        'applicant_location',
        'applicant',
        'contractor',
        'type',
        'priority',
        'status',
        'author',
        'comments.author'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->status_id = TicketStatus::new()->first()->id ?? null;
            $model->author_id = auth()->user()->id ?? null;
        });
    }

    #region Relations methods and scoped

    public function forEdit()
    {
        return $this->load($this->relationsForEdit);
    }

    public function scopeForEdit($query)
    {
        return $query->with($this->relationsForEdit);
    }

    public function forList()
    {
        return $this->load($this->relationsForList);
    }

    public function scopeForList($query)
    {
        return $query->with($this->relationsForList);
    }

    #endregion

    #region Relations

    public function author()
    {
        return $this->belongsTo(User::class);
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

    public function contractor()
    {
        return $this->belongsTo(User::class);
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
