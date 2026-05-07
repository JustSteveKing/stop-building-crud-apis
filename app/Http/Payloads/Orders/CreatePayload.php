<?php

declare(strict_types=1);

namespace App\Http\Payloads\Orders;

use App\Enums\OrderStatus;

final readonly class CreatePayload
{
    public function __construct(
        public OrderStatus $status,
    ) {}

    /**
     * @return array{status: OrderStatus}
     */
    public function toArray(): array
    {
        return [
            'status' => $this->status->value,
        ];
    }
}
