<?php

declare(strict_types=1);

namespace App\StateMachines\Orders;

use App\Enums\OrderStatus;

final class OrderPendingState extends OrderState
{
    public function ready(): void
    {
        $this->order->update([
            'status' => OrderStatus::Ready,
        ]);
    }

    public function cancel(): void
    {
        $this->order->update([
            'status' => OrderStatus::Cancelled,
        ]);
    }
}
