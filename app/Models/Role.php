<?php

namespace App\Models;

use App\Base\Traits\HasRules;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
#[Fillable(['name','display_name'])]
class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory,HasRules;

    public function permissions():BelongsToMany
    {
        return  $this->belongsToMany(Permission::class);
    }
    protected static $rules=[
       'name'=>'required|string|unique:roles,name',
       'display_name'=>'required|string',
        'permissions'=>'required|array',
        'permissions.*'=>'exists:permissions,id',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
