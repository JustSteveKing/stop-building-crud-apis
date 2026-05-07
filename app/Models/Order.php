<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\StateMachines\Orders\OrderCancelledState;
use App\StateMachines\Orders\OrderCookingState;
use App\StateMachines\Orders\OrderDeliveredState;
use App\StateMachines\Orders\OrderPendingState;
use App\StateMachines\Orders\OrderReadyState;
use App\StateMachines\Orders\OrderStateContract;
use Carbon\CarbonInterface;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property OrderStatus $status
 * @property string $user_id
 * @property CarbonInterface|null $started_cooking_at
 * @property CarbonInterface|null $completed_at
 * @property CarbonInterface|null $cancelled_at
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 * @property-read User $user
 * @property-read Collection<int,OrderItem> $items
 */
class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;
    use HasUlids;

    /** @var list<string> */
    protected $fillable = [
        'status',
        'user_id',
        'started_cooking_at',
        'completed_at',
        'cancelled_at',
    ];

    /** @return BelongsTo<User,$this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
        );
    }

    /** @return HasMany<OrderItem,$this> */
    public function items(): HasMany
    {
        return $this->hasMany(
            related: OrderItem::class,
            foreignKey: 'order_id',
        );
    }

    public function state(): OrderStateContract
    {
        return match ($this->status) {
            OrderStatus::Pending => new OrderPendingState($this),
            OrderStatus::Cooking => new OrderCookingState($this),
            OrderStatus::Ready => new OrderReadyState($this),
            OrderStatus::Delivered => new OrderDeliveredState($this),
            OrderStatus::Cancelled => new OrderCancelledState($this),
        };
    }

    /** @return array<string,class-string|string> */
    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'started_cooking_at' => 'datetime',
            'completed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }
}
