<?php

declare(strict_types=1);

namespace App\Http\Controllers\Orders;

use App\Enums\OrderStatus;
use App\Http\Requests\Orders\StoreRequest;
use App\Http\Resources\OrderResource;
use App\Jobs\Orders\CreateNewOrder;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class StoreController
{
    public function __construct(
        private readonly Dispatcher $bus,
    ) {}

    public function __invoke(StoreRequest $request, #[CurrentUser] User $user): Response
    {
        $this->bus->dispatch(
            command: new CreateNewOrder(
                payload: $request->payload(),
                user: $user,
            ),
        );

        return new JsonResponse(
            data: [
                'message' => 'Order is being created.',
            ],
            status: Response::HTTP_ACCEPTED,
        );
    }
}
