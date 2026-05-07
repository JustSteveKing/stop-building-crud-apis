<?php

declare(strict_types=1);

namespace App\StateMachines\Orders;

use App\Enums\OrderStatus;

final class OrderReadyState extends OrderState
{
    public function delivered(): void
    {
        $this->order->update([
            'status' => OrderStatus::Delivered,
        ]);
    }

    public function cancel(): void
    {
        $this->order->update([
            'status' => OrderStatus::Cancelled,
        ]);
    }
}
