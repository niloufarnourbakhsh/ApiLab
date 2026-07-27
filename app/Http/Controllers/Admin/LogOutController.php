<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\RestfulApi\Facades\ApiResponse;
use Illuminate\Http\Request;

class LogOutController extends Controller
{
    public function __invoke()
    {
//        auth()->user()->tokens()->delete();
        auth()->user()->currentAccessToken()->delete();
        return ApiResponse::withMessage('log out successfully')->withStatus(200)->build()->response();
    }
}
