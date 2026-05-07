<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\Orders\DeleteRequest;
use App\Http\Requests\Orders\ListRequest;
use App\Http\Requests\Orders\ShowRequest;
use App\Http\Requests\Orders\StoreRequest;
use App\Http\Requests\Orders\UpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class OrderController
{
    public function index(ListRequest $request, #[CurrentUser] User $user): Response
    {
        // Authorization is handled in ListRequest
        $orders = $user->orders()->simplePaginate();

        return OrderResource::collection(
            resource: $orders,
        )->toResponse($request);
    }

    public function store(StoreRequest $request, #[CurrentUser] User $user): Response
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

    public function show(ShowRequest $request, #[CurrentUser] User $user, string $id): Response
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

    public function update(UpdateRequest $request, #[CurrentUser] User $user, string $id): Response
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

    public function destroy(DeleteRequest $request, #[CurrentUser] User $user, string $id): Response
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
