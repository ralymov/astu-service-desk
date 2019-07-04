<?php

namespace App\Models\Storage\User;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string code
 * @property string name
 * @property string display_name
 */
class Role extends Model
{

    public const FLD_ID = 'id';
    public const FLD_NAME = 'name';
    public const FLD_DISPLAY_NAME = 'display_name';
    public const FLD_CODE = 'code';

    public const ADMIN = 'admin';
    public const CONTRACTOR = 'contractor';
    public const DEPARTMENT_HEAD = 'department_head';
    public const GUEST = 'guest';

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
