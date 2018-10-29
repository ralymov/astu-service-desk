<?php

namespace App\Models\Storage\Employee;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'department_positions');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

}
