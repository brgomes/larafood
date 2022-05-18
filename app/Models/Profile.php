<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['name', 'description'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_profile');
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class);
    }

    public function search($filter = null)
    {
        $results = $this->where('name', 'LIKE', "%{$filter}%")
            ->orWhere('description', 'LIKE', "%{$filter}%")
            ->paginate();

        return $results;
    }

    public function permissionsAvailable($filter = null)
    {
        $permissions = Permission::whereNotIn('id', function ($query) {
            $query->select('permission_id')
                ->from('permission_profile')
                ->whereRaw("permission_profile.profile_id = {$this->id}");
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
