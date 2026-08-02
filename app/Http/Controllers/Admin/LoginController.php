<?php

namespace App\Http\Controllers\Admin;

use App\Http\ApiRequests\Admin\Auth\LoginApiRequest;
use App\Http\Controllers\Controller;
use App\RestfulApi\Facades\ApiResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class LoginController extends Controller
{
    #[OA\Post(
        path: '/login',
        description : 'Login User',
        summary: 'Login User',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email','password'],
                properties: [
                    new OA\Property(property: 'email',type: 'string',format: 'email',example: 'niloufar@example.com'),
                    new OA\Property(property: 'password',type: 'string',format: 'password',example: '12345678'),
                ]
            )
        ),
        tags: ['Login'],
        responses: [
            new OA\Response(response: 200,
                description: 'successful operation!!!',
                content: new OA\JsonContent()),
            new OA\Response(response: 422, description: 'invalid ')
        ],
    )]
    public function __invoke(LoginApiRequest $request)
    {
        if (! auth()->attempt($request->validated())){
            return ApiResponse::withMessage(__('auth.failed'))->withStatus(401)->build()->response();
        }
        $user=auth()->user();
        $token= $user->createToken(\request()->header('User-agent'))->plainTextToken;
        return ApiResponse::withAppends([
            'name'=>$user->name,
            'token'=>$token
        ])->build()->response();
    }
}
