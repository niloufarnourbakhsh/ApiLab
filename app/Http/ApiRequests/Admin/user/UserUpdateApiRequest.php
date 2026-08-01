<?php

namespace App\Http\ApiRequests\Admin\user;

use App\Models\User;
use App\RestfulApi\ApiFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UserUpdateApiRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update_user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return User::rules([
            'email'=>['required','email',Rule::unique('users','email')->ignore($this->user->id)],
            'password'=>'nullable|min:8|max:255',
        ]);
    }
}
