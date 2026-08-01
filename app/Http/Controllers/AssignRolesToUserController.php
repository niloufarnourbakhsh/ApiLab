<?php

namespace App\Http\Controllers;

use App\Http\ApiRequests\Admin\AccessLevel\AssignRoleToUserApiRequest;
use App\Models\User;
use App\RestfulApi\Facades\ApiResponse;
use App\Services\AccessLevelService;
use Illuminate\Http\Request;

class AssignRolesToUserController extends Controller
{
    public function __construct(public AccessLevelService $service)
    {
    }
    public function __invoke(AssignRoleToUserApiRequest $request,User $user)
    {
        $result=$this->service->assignRolesToUser($user, $request->validated()['roles']);
        if (!$result->ok) {
            return ApiResponse::withMessage('something went wrong')->withStatus(500)->build()->response();
        }
        return ApiResponse::build()->response();
    }
}
