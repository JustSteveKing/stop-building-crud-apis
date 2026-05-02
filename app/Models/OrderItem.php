<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\OrderItemFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $name
 * @property int $quantity
 * @property string $order_id
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 * @property-read Order $order
 */
class OrderItem extends Model
{
    /** @use HasFactory<OrderItemFactory> */
    use HasFactory;
    use HasUlids;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'quantity',
        'order_id',
    ];

    /** @return BelongsTo<Order,$this> */
    public function order(): BelongsTo
    {
        return $this->belongsTo(
            related: Order::class,
            foreignKey: 'order_id',
        );
    }

    /** @return array<string,string> */
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }
}
