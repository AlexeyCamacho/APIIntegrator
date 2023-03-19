<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Collection;

trait HasRolesAndPermissions
{
    public function roles($company = null)
    {
        return $this->belongsToMany(Role::class,'users_roles_companies')
            ->withPivot('company_id')->where('company_id', $company)->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'users_permissions')->withTimestamps();
    }

    public function hasRole($company = null, ... $roles) {
        foreach ($roles as $role) {
            if ($this->roles($company)->get()->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermission($permission, $company = null)
    {
        return (bool) $this->permissions($company)->where('slug', $permission)->count();
    }

    public function hasPermissionTo($permission, $company = null)
    {
        $permission = Permission::where('slug', $permission)->first();
        return $this->hasPermissionThroughRole($permission, $company) || $this->hasPermission($permission->slug, $company);
    }

    public function hasPermissionThroughRole($permission, $company = null)
    {
        foreach ($permission->roles as $role){
            if($this->roles($company)->get()->contains($role)) {
                return true;
            }
        }
        return false;
    }

    public function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug',$permissions)->get();
    }

    public function getPermissions($company = null)
    {
        $permissions = $this->permissions()->get();
        $rolesPermissions = $this->roles($company)->get()->map(function (Role $role) {
             return $role->permissions()->get();
        });

        foreach ($rolesPermissions as $collect) {
            $permissions = $permissions->merge($collect);
        }

        $permissions = $permissions->map(function (Permission $permission) {
            return $permission->slug;
        });

        return $permissions;
    }

    public function givePermissionsTo(... $permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        if($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    public function deletePermissions(... $permissions )
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    public function refreshPermissions(... $permissions )
    {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }

    public function getAllRoles($role, $global = true)
    {
        return Role::where('slug',$role)->where('global', $global)->get()->first();
    }

    public function giveRoleTo($company, $role)
    {
        $role = $this->getAllRoles($role, !$company);
        if ($role === null || $this->hasRole($company, $role->slug)) {
            return $this;
        }
        $this->roles()->save($role, ['company_id' => $company]);
        return $this;
    }
}
