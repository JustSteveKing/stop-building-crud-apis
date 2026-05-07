<?php

namespace App\Jobs\Orders;

use App\Http\Payloads\Orders\CreatePayload;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;

class CreateNewOrder implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public CreatePayload $payload,
        public User $user,
    ) {}

    public function handle(): void
    {
        $this->user->orders()->create(
            attributes: $this->payload->toArray(),
        );
    }
}
