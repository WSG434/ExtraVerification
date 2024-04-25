<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendVerificationCodeRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'int'],
            'email' => ['required', 'string', 'email'],
        ];
    }
}
