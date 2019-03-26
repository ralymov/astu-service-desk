<?php

namespace App\Models\Storage\User;

use App\Models\Storage\Employee\Location;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 */
class UserDepartment extends Model
{

    protected $guarded = ['id'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

}
