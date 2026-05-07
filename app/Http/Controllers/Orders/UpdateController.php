<?php

declare(strict_types=1);

namespace App\Http\Controllers\Orders;

use App\Http\Requests\Orders\UpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

final class UpdateController
{
    public function __invoke(UpdateRequest $request, #[CurrentUser] User $user, string $id): Response
    {
        $order = Order::query()->findOrFail($id);

        if (! Gate::allows('update', $order)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $order->update(
            attributes: $request->validated(),
        );

        return new OrderResource(
            resource: $order,
        )->toResponse($request);
    }
}
