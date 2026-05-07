<?php

declare(strict_types=1);

namespace App\Http\Controllers\Orders\Status;

use App\Enums\OrderStatus;
use App\Http\Requests\Orders\UpdateRequest;
use App\Http\Resources\OrderResource;
use App\Jobs\Orders\ProgressOrder;
use App\Models\Order;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

final readonly class CookingController
{
    public function __construct(
        private Dispatcher $bus,
    ) {}

    public function __invoke(UpdateRequest $request, #[CurrentUser] User $user, string $id): Response
    {
        $order = Order::query()->findOrFail($id);

        if (! Gate::allows('update', $order)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->bus->dispatch(
            command: new ProgressOrder(
                order: $order,
                state: OrderStatus::Cooking,
            ),
        );

        return new JsonResponse(
            data: [
                'message' => 'Order will be set to cooking.',
            ],
            status: Response::HTTP_ACCEPTED,
        );
    }
}
