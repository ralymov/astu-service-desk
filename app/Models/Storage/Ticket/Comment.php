<?php

namespace App\Models\Storage\Ticket;

use App\Models\Storage\User\User;
use App\Traits\FormatDateTrait;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use FormatDateTrait;

    protected $guarded = ['id'];
    protected $with = ['author'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->author_id = auth()->user()->id ?? null;
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

}
