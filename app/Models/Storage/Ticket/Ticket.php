<?php

namespace App\Models\Storage\Ticket;

use App\Models\Storage\Employee\Employee;
use App\Models\Storage\Employee\Location;
use App\Models\Storage\Ticket\References\TicketPriority;
use App\Models\Storage\Ticket\References\TicketStatus;
use App\Models\Storage\Ticket\References\TicketType;
use App\Models\Storage\User\Role;
use App\Models\Storage\User\User;
use App\Models\Storage\User\UserDepartment;
use App\Traits\FormatDateTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 */
class Ticket extends Model
{
    use FormatDateTrait;

    protected $guarded = ['id'];
    private static $relationsForList = [
        'applicant_location',
        'applicant',
        'contractor',
        'department',
        'type',
        'priority',
        'status'
    ];
    private static $relationsForEdit = [
        'applicant_location',
        'applicant',
        'contractor',
        'type',
        'priority',
        'status',
        'author',
        'comments.author',
        'history.author'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(static function ($model) {
            $model->status_id = TicketStatus::new()->first()->id ?? null;
            $model->author_id = auth()->user()->id ?? null;
        });
    }

    #region Setters and getter

    public function setClosedAtAttribute($date = null): void
    {
        if (!$date) return;
        TicketHistory::create([
            'ticket_id' => $this->id,
            'author_id' => auth()->user()->id,
            'description' => 'Заявка была отмечена как выполненная'
        ]);
        $this->attributes['closed_at'] = Carbon::parse($date);
    }

    public function setStatusIdAttribute($statusId): void
    {
        if ($this->id) {
            $oldStatus = $this->status;
            $newStatus = TicketStatus::find($statusId);
            TicketHistory::create([
                'ticket_id' => $this->id,
                'author_id' => auth()->user()->id,
                'description' => "Статус изменен с `$oldStatus->name` на `$newStatus->name`",
            ]);
        }
        $this->attributes['status_id'] = $statusId;
    }

    #endregion

    #region Relations methods and scopes

    public function scopeForRole($query)
    {
        $user = auth()->user();
        $roleCode = $user->role->code;
        switch ($roleCode) {
            case Role::ADMIN:
                return $query;
            case Role::CONTRACTOR:
                return $query->forEmployee($user);
            case Role::DEPARTMENT_HEAD:
                return $query->forHead($user);
            default:
                return $query->whereAuthorId($user->id);
                break;
        }
    }

    public function scopeForEmployee($query, User $user)
    {
        return $query->whereContractorId($user->id)
            ->orWhere([
                ['department_id', $user->department_id],
                ['contractor_id', null]
            ]);
    }

    public function scopeForHead($query, User $user)
    {
        return $query->whereContractorId($user->id)
            ->orWhere('department_id', $user->department_id);
    }

    public function forEdit()
    {
        return $this->load(self::$relationsForEdit);
    }

    public function scopeForEdit($query)
    {
        return $query->with(self::$relationsForEdit);
    }

    public function forList()
    {
        return $this->load(self::$relationsForList);
    }

    public function scopeForList($query)
    {
        return $query->with(self::$relationsForList);
    }

    #endregion

    #region Relations

    public function history()
    {
        return $this->hasMany(TicketHistory::class)->orderBy('id', 'desc');
    }

    public function department()
    {
        return $this->belongsTo(UserDepartment::class);
    }

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
