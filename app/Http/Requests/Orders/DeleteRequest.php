<?php

namespace App\Http\Requests\Orders;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DeleteRequest extends FormRequest
{
    /** @return array<string, ValidationRule|array|string> */
    public function rules(): array
    {
        return [];
    }
}
