<?php

namespace App\Models\Storage\Employee;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 */
class Department extends Model
{

    protected $guarded = ['id'];

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'department_positions');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

}
