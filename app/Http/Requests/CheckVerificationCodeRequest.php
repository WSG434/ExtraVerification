<?php

namespace App\Http\Requests;

class CheckVerificationCodeRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required'],
        ];
    }
}
