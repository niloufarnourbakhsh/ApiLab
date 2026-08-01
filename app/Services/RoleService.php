<?php

namespace App\Services;

use App\Base\ServiceResult;
use App\Base\ServiceWrapper;
use App\Models\Role;
use Illuminate\Support\Arr;

class RoleService
{
    public function AddNewRole(array $inputs):ServiceResult
    {
        return app(ServiceWrapper::class)(function ()use($inputs){
            $role=Role::query()->create(Arr::except($inputs,'permissions'));
            $role->permissions()->attach($inputs['permissions']);
            return $role;
        });
    }
    public function UpdateRole(array $inputs,Role $role):ServiceResult
    {
        return app(ServiceWrapper::class)(function ()use($inputs,$role){
             $role->Update(Arr::except($inputs,'permissions'));
            $role->permissions()->sync($inputs['permissions']);
             return $role;
        });
    }
}
