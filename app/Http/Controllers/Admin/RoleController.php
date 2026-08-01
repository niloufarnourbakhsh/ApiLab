<?php

namespace App\Http\Controllers\Admin;

use App\Http\ApiRequests\Admin\Role\RoleStoreApiRequest;
use App\Http\ApiRequests\Admin\Role\RoleUpdateApiRequest;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\RestfulApi\Facades\ApiResponse;
use App\Services\RoleService;

class RoleController extends Controller
{
    public function __construct(public  RoleService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreApiRequest $request)
    {

        $result = $this->service->AddNewRole($request->validated());
        if (!$result->ok) {
            return ApiResponse::withMessage('something went wrong')->withStatus(500)->build()->response();
        }
        return ApiResponse::withMessage('Role Created successfully')
            ->withData($result->data)->build()->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateApiRequest $request, Role $role)
    {
        $updated = $this->service->UpdateRole($request->validated(),$role);
        if (!$updated->ok) {
            return ApiResponse::withMessage('something went wrong')->withStatus(500)->build()->response();
        }
        return ApiResponse::withMessage('Role update successfully')->withData($updated->data)->build()->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
