<?php

namespace App\Services;

use App\Base\ServiceResult;
use App\Base\ServiceWrapper;
use App\Models\User;

class AccessLevelService
{
    public function assignRolesToUser(User $user,array $role_id):ServiceResult
    {
      return  app(ServiceWrapper::class)(function ()use ($user, $role_id){
            return $user->roles()->sync($role_id);
        });
    }

}
