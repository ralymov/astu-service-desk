<?php

namespace App\Models\Storage\Employee;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    protected $guarded = ['id'];
    protected $with = ['department', 'position'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

}
