<?php

namespace App\Jobs\Orders;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;

class ProgressOrder implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Order $order,
        public OrderStatus $state,
    ) {}

    public function handle(): void
    {
        $stateMachine = $this->order->state();

        match ($this->state) {
            OrderStatus::Cooking => $stateMachine->cooking(),
            OrderStatus::Ready => $stateMachine->ready(),
            OrderStatus::Delivered => $stateMachine->delivered(),
            default => throw new InvalidArgumentException('Invalid order state'),
        };
    }
}
