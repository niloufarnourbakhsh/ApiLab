<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;
#[OA\Schema(
    schema: 'UsersItemSchema',
    properties: [
        new OA\Property(property: 'status',type: 'integer',example: '200'),
        new OA\Property(property: 'data',type: 'array', items: new OA\Items(type: 'string'),example: '[id=>1,name=>ali]'),
    ],
    type: 'object',
)]
class UserListApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
            'id'=>$this->id,
            'fullName'=> $this->full_name,
        ];
    }
}
