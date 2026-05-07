<?php

declare(strict_types=1);

namespace App\StateMachines\Orders;

use App\Models\Order;
use LogicException;

abstract class OrderState implements OrderStateContract
{
    public function __construct(
        public Order $order,
    ) {}

    public function pending()
    {
        throw new LogicException(
            message: 'Order cannot be pending.',
        );
    }

    public function ready(): void
    {
        throw new LogicException(
            message: 'Order cannot be ready.',
        );
    }

    public function cooking(): void
    {
        throw new LogicException(
            message: 'Order cannot be cooking.',
        );
    }

    public function delivered(): void
    {
        throw new LogicException(
            message: 'Order cannot be delivered.',
        );
    }

    public function cancelled(): void
    {
        throw new LogicException(
            message: 'Order cannot be cancelled.',
        );
    }
}
