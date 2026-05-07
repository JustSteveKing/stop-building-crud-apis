<?php

namespace App\Http\Requests\Orders;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create', Order::class);
    }

    /** @return array<string, ValidationRule|array|string> */
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::enum(OrderStatus::class),
                'max:255',
            ],
        ];
    }
}
