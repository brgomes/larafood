<?php

namespace App\Models;

use App\Models\Traits\UserACLTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, UserACLTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenant_id', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('tenant', function (Builder $builder) {
            $builder->where('tenant_id', auth()->user()->tenant_id);
        });
    }*/

    public function scopeTenantUser(Builder $query)
    {
        return $query->where('tenant_id', auth()->user()->tenant_id);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function rolesAvailable($filter = null)
    {
        $roles = Role::whereNotIn('id', function ($query) {
            $query->select('role_user.role_id')
                ->from('role_user')
                ->whereRaw("role_user.user_id = {$this->id}");
        })
        ->where(function ($queryFilter) use ($filter) {
            if (isset($filter)) {
                $queryFilter->where('roles.name', 'LIKE', "%{$filter}%");
            }
        })
        ->paginate();

        return $roles;
    }
}
