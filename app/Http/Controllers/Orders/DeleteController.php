<?php

declare(strict_types=1);

namespace App\Http\Controllers\Orders;

use App\Http\Requests\Orders\DeleteRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

final class DeleteController
{
    public function __invoke(DeleteRequest $request, #[CurrentUser] User $user, string $id): Response
    {
        /** @var Order $order */
        $order = Order::query()->findOrFail($id);

        if (! Gate::allows('delete', $order)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $order->delete();

        return new JsonResponse(
            data: null,
            status: Response::HTTP_NO_CONTENT,
        );
    }
}
