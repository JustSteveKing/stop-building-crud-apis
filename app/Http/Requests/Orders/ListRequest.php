<?php

namespace App\Http\Requests\Orders;

use App\Models\Order;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('list', Order::class);
    }

    /** @return array<string, ValidationRule|array|string> */
    public function rules(): array
    {
        return [];
    }
}
