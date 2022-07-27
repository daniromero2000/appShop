<?php

namespace App\Http\Transformers\Products;

use App\Models\Orders\Order;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

/**
 * Class ProductTransformer
 */
class OrderTransformer extends TransformerAbstract
{
    /**
     * @var array
     * @see includeProducts
     */
    protected array $defaultIncludes = [
        'products',
    ];

    /**
     * @param Order $order
     * @return array
     */
    public function transform(Order $order): array
    {
        return [
            'id' => $order->id,
            'user_id' => $order->user_id,
            'total' => $order->total,
            'status' => $order->status,
        ];
    }

    /**
     * @param Order $order
     * @return Collection
     */
    public function includeProducts(Order $order): Collection
    {
        return $this->collection($order->orderProducts, new OrderProductsTransformer(), 'products');
    }
}
