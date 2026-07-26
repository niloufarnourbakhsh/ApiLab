<?php

namespace App\Http\Controllers\Admin;

use App\Http\ApiRequests\Admin\user\UserCreateApiRequest;
use App\Http\ApiRequests\Admin\user\UserUpdateApiRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\user\UserStoreRequest;
use App\Http\Resources\Admin\User\UserDetailsApiResource;
use App\Http\Resources\Admin\User\UserListApiResource;
use App\Models\User;
use App\Services\UserService;
use http\Env\Response;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use \App\RestfulApi\Facades\ApiResponse;

class UserController extends Controller
{

    public function __construct( public UserService $userService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usersQuery=User::query();
        if (\request()->has('email')){
            $usersQuery=$usersQuery->where('email','like',\request('email'));
        }
        $users=$usersQuery->paginate(8);
        return UserListApiResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateApiRequest $request)
    {
        $result=$this->userService->RegisterUser($request->validated());
            if (!$result->ok){
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
        return new UserDetailsApiResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateApiRequest $request, User $user)
    {
        try {
            $inputs=$request->validated();
            $user->update($inputs);
        }catch (\Throwable $throwable){
            app()[ExceptionHandler::class]->report($throwable);
            return \response()->json([
                'message'=>'somthing went wrong'
            ],500);
        }
        return response()->json([
            'message'=>'User Updated successfully',
            'data'=>$user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
        }catch (\Throwable $throwable){
            app()[ExceptionHandler::class]->report($throwable);
            return \response()->json([
                'message'=>'somthing went wrong'
            ],500);
        }
        return response()->json([
            'message'=>'User deleted successfully',
        ]);
    }
//    protected function ApiResponse($message=null,$data=null, $status=200){
//        $body=[];
//        !is_null($message) && $body['message']=$message;
//        !is_null($data) && $body['data']=$data;
//
//        return \response()->json($body,$status);
//    }
}
