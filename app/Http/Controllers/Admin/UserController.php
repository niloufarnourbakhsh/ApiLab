<?php

namespace App\Http\Controllers\Admin;

use App\Http\ApiRequests\Admin\User\DeleteApiRequest;
use App\Http\ApiRequests\Admin\User\IndexApiRequest;
use App\Http\ApiRequests\Admin\User\ShowApiRequest;
use App\Http\ApiRequests\Admin\user\UserCreateApiRequest;
use App\Http\ApiRequests\Admin\user\UserUpdateApiRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\User\UserDetailsApiResource;
use App\Http\Resources\UsersListApiResourceCollection;
use App\Models\User;
use App\Services\UserService;
use \App\RestfulApi\Facades\ApiResponse;
use OpenApi\Attributes as OA;

class UserController extends Controller
{

    public function __construct(public UserService $userService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/users',
        description : 'Get all Users',
        summary: 'get all users',
        security :[['sanctum' => []]],
//        security :[['bearerAuth'=> []]],
        tags: ['Users'],
        parameters: [
            new OA\Parameter(name: 'email', description: 'path description',in: 'query',required: false ),
            new OA\Parameter(name: 'is_active',in: 'query', required: true,
                schema: new OA\Schema( type: "boolean", default: true))
        ],
        responses: [
            new OA\Response(response: 200,
                description: 'successful operation!!!',
                content: new OA\JsonContent(ref: '#/components/schemas/UsersItemSchema')),
            new OA\Response(response: 403, description: 'unauthorize', content: new OA\JsonContent(ref: '#/components/schemas/403ResponseSchema'))
        ],
    )]
    public function index(IndexApiRequest $request)
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
    #[OA\Get(
        path: '/users/{user}',
        description : 'Show a User',
        summary: 'get a specific user',
        security :[['sanctum' => []]],
//        security :[['bearerAuth'=> []]],
        tags: ['Users'],
        parameters: [
            new OA\Parameter(name: 'is_active',in: 'path', required: true,
                schema: new OA\Schema( type: "boolean", default: true))
        ],
        responses: [
            new OA\Response(response: 200,
                description: 'successful operation!!!',
                content: new OA\JsonContent(ref: '#/components/schemas/UsersItemSchema')),
            new OA\Response(response: 403, description: 'unauthorize', content: new OA\JsonContent(ref: '#/components/schemas/403ResponseSchema'))
        ],
    )]
    public function show(User $user,ShowApiRequest $request)
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
    public function destroy(User $user, DeleteApiRequest $request)
    {
        $deletion=$this->userService->deleteUser($user);
        if (! $deletion->ok){
            return ApiResponse::withMessage('something went wrong')->withStatus(404)->build()->response();
        }
        return ApiResponse::withMessage('no Content')->build()->response();
    }

}
