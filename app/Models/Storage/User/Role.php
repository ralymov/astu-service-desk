<?php

namespace App\Models\Storage\User;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public const FLD_ID = 'id';
    public const FLD_NAME = 'name';
    public const FLD_DISPLAY_NAME = 'display_name';
    public const FLD_CODE = 'code';

    public const admin = 'admin';
    public const contractor = 'contractor';

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
