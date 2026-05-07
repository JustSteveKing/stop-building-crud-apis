<?php

declare(strict_types=1);

namespace App\Http\Controllers\Orders;

use App\Enums\OrderStatus;
use App\Http\Requests\Orders\StoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Symfony\Component\HttpFoundation\Response;

final class StoreController
{
    public function __invoke(StoreRequest $request, #[CurrentUser] User $user): Response
    {
        // Authorization is handled in StoreRequest
        $order = $user->orders()->create([
            'status' => OrderStatus::tryFrom(
                value: $request->string('status')->toString(),
            ),
        ]);

        return new OrderResource(
            resource: $order,
        )->toResponse($request);
    }
}
