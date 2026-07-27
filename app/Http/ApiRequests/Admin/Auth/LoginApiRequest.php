<?php

namespace App\Http\ApiRequests\Admin\Auth;

use App\RestfulApi\ApiFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class LoginApiRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'=>'required|email',
            'password'=>'required'
        ];
    }
}
