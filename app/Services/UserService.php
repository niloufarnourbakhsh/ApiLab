<?php

namespace App\Services;

use App\Base\ServiceResult;
use App\Base\ServiceWrapper;
use App\Models\User;
use App\RestfulApi\Facades\ApiResponse;
use Illuminate\Contracts\Debug\ExceptionHandler;

class UserService
{
    public function RegisterUser( array $input):ServiceResult
    {
        return  app(ServiceWrapper::class)(function ()use ($input){
           return User::query()->create($input);
        });
    }
}
