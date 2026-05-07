<?php

declare(strict_types=1);

namespace App\Http\Controllers\Orders;

use App\Http\Requests\Orders\ShowRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

final class ShowController
{
    public function __invoke(ShowRequest $request, #[CurrentUser] User $user, string $id): Response
    {
        /** @var Order $order */
        $order = Order::query()->findOrFail($id);

        if (! Gate::allows('view', $order)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return new OrderResource(
            resource: $order,
        )->toResponse($request);
    }
}
