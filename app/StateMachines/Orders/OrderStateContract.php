<?php

declare(strict_types=1);

namespace App\StateMachines\Orders;

interface OrderStateContract
{
    public function ready();

    public function cooking();

    public function delivered();

    public function cancelled();

    public function pending();
}
