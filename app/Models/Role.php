<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'description'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissionsAvailable($filter = null)
    {
        $permissions = Permission::whereNotIn('id', function ($query) {
            $query->select('permission_id')
                ->from('permission_role')
                ->whereRaw("permission_role.role_id = {$this->id}");
        })
        ->where(function ($queryFilter) use ($filter) {
            if (isset($filter)) {
                $queryFilter->where('permissions.name', 'LIKE', "%{$filter}%");
            }
        })
        ->paginate();

        return $permissions;
    }
}
