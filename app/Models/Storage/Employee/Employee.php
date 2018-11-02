<?php

namespace App\Models\Storage\Employee;

use App\Models\Storage\Employee\References\EmployeeType;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    protected $guarded = ['id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function type()
    {
        return $this->belongsTo(EmployeeType::class);
    }

}
