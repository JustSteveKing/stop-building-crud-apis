<?php

declare(strict_types=1);

namespace App\Http\Controllers\Orders;

use App\Http\Requests\Orders\ListRequest;
use App\Http\Resources\OrderResource;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Symfony\Component\HttpFoundation\Response;

final class IndexController
{
    public function __invoke(ListRequest $request, #[CurrentUser] User $user): Response
    {
        // Authorization is handled in ListRequest
        $orders = $user->orders()->simplePaginate();

        return OrderResource::collection(
            resource: $orders,
        )->toResponse($request);
    }
}
