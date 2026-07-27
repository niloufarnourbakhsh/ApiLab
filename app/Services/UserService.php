<?php

namespace App\Services;

use App\Base\ServiceResult;
use App\Base\ServiceWrapper;
use App\Models\User;
use App\RestfulApi\Facades\ApiResponse;
use Illuminate\Contracts\Debug\ExceptionHandler;

class UserService
{
    public function getAllUsers(array $inputs):ServiceResult
    {
        return app(ServiceWrapper::class)(function ()use($inputs){
            return User::query()->paginate();
        });
    }
    public function RegisterUser( array $input):ServiceResult
    {
        return  app(ServiceWrapper::class)(function ()use ($input){
           return User::query()->create($input);
        });
    }

    public function getUserInfo(User $user) :ServiceResult
    {
        return app(ServiceWrapper::class)(fn() => $user);
    }

    public function updateUser(User $user,array $inputs):ServiceResult
    {
        return app(ServiceWrapper::class)(function () use($user ,$inputs){
            $user->update($inputs);
            return $user;
        });
    }

    public function deleteUser(User $user):ServiceResult
    {
       return app(ServiceWrapper::class)(fn()=>$user->delete());
    }
}
