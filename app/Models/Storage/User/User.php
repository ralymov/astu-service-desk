<?php

namespace App\Models\Storage\User;

use App\Models\Storage\Employee\Department;
use App\Models\Storage\Employee\Position;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property int id
 * @property string name
 * @property string username
 * @property string password
 * @property integer role_id
 * @property Role role
 * @property int department_id
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public const FLD_ID = 'id';
    public const FLD_USERNAME = 'username';
    public const FLD_PASSWORD = 'password';
    public const FLD_ROLE_ID = 'role_id';

    public function isAdmin(): bool
    {
        return $this->role->code === Role::ADMIN;
    }

    public function isEmployee(): bool
    {
        return $this->role->code === Role::CONTRACTOR;
    }

    public function isHead(): bool
    {
        return $this->role->code === Role::DEPARTMENT_HEAD;
    }

    public function isGuest(): bool
    {
        return $this->role->code === Role::GUEST;
    }

    public function updateUser(array $attributes = []): self
    {
        $this->username = $attributes['username'];
        $this->role_id = $attributes['role_id'];
        $this->password = \Hash::make($attributes['password']);
        return $this;
    }

    public function department()
    {
        return $this->belongsTo(UserDepartment::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
