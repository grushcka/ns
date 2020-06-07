<?php

namespace NS\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     * @Todo think about rules
     * @return array
     */
    public function rules(): array
    {
        return [
            'login' => 'required',
        ];
    }
}
