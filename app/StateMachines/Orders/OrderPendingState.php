<?php

declare(strict_types=1);

namespace App\StateMachines\Orders;

use App\Enums\OrderStatus;

final class OrderPendingState extends OrderState
{
    public function cooking(): void
    {
        $this->order->update([
            'status' => OrderStatus::Cooking,
        ]);
    }

    public function cancel(): void
    {
        $this->order->update([
            'status' => OrderStatus::Cancelled,
        ]);
    }
}
