<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Admin\User\UserListApiResource;

class UsersListApiResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
            'data'=>UserListApiResource::collection($this->collection),
            'meta'=>[
                'total'=>$this->collection->count(),
                'perpage'=>$this->perPage(),
                'current_page'=>$this->currentPage(),
                'last_page'=>$this->lastPage(),
                'fist-item'=>$this->firstItem(),
                'last-item'=>$this->lastItem(),
            ],[
                'links'=>[
                    'first'=>$this->url(1),
                    'last'=>$this->url($this->lastPage()),
                    'prev'=>$this->url($this->currentPage()-1),
                    'next'=>$this->url($this->currentPage()+1),
                ]
            ]
        ];
    }
}
