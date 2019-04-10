<?php

namespace App\Models\Storage\Ticket;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for events (such as olympiads, conference, etc.)
 * @property integer id
 */
class Event extends Model
{

    protected $guarded = ['id'];

//    public function getDateAttribute($date): ?string
//    {
//        if (!$date) return null;
//        return Carbon::parse($date)->format('d.m.Y');
//    }

}
