<?php

namespace App\Http\Controllers\Admin;

use App\Http\ApiRequests\Admin\user\UserCreateApiRequest;
use App\Http\ApiRequests\Admin\user\UserUpdateApiRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\user\UserStoreRequest;
use App\Http\Resources\Admin\User\UserDetailsApiResource;
use App\Http\Resources\Admin\User\UserListApiResource;
use App\Http\Resources\UsersListApiResourceCollection;
use App\Models\User;
use App\Services\UserService;
use http\Env\Response;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use \App\RestfulApi\Facades\ApiResponse;

class UserController extends Controller
{

    public function __construct(public UserService $userService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        if (! Gate::allows('test')){
//            return ApiResponse::withStatus(403)->build()->response();
//        }
        $result = $this->userService->getAllUsers(\request()->all());
        if (!$result->ok) {
            return ApiResponse::withMessage('sorry something went wrong')->withStatus(500)->build()->response();
        }
        return ApiResponse::withData(new UsersListApiResourceCollection($result->data))->build()->response();
//        return ApiResponse::withData(UserListApiResource::collection($result->data)->resource)->build()->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateApiRequest $request)
    {
        $result = $this->userService->RegisterUser($request->validated());
        if (!$result->ok) {
            return ApiResponse::withMessage('something went wrong')->withStatus(500)->build()->response();
        }
        return ApiResponse::withMessage('user Created successfully')
            ->withData($result->data)->build()->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = $this->userService->getUserInfo($user);
        if (!$user->ok) {
            return ApiResponse::withMessage('user Not Found')->withData(404)->build()->response();
        }
        return ApiResponse::withData(new UserDetailsApiResource($user->data))->build()->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateApiRequest $request, User $user)
    {
        $updated = $this->userService->updateUser($user, $request->validated());
        if (!$updated->ok) {
            return ApiResponse::withMessage('something went wrong')->withStatus(500)->build()->response();
        }
        return ApiResponse::withMessage('update successfully')->withData($updated->data)->build()->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $deletion=$this->userService->deleteUser($user);
        if (! $deletion->ok){
            return ApiResponse::withMessage('something went wrong')->withStatus(404)->build()->response();
        }
        return ApiResponse::withMessage('no Content')->build()->response();
    }

}
