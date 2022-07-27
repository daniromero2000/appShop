<?php

namespace App\Http\Transformers\Products;

use App\Models\Orders\OrderProduct;
use League\Fractal\TransformerAbstract;

/**
 * Class DetailOrderProductsTransformer
 */
class OrderProductsTransformer extends TransformerAbstract
{
    /**
     * @param OrderProduct $orderProduct
     * @return array
     */
    public function transform(OrderProduct $orderProduct): array
    {
        return [
            'id' => $orderProduct->product->id,
            'name' => $orderProduct->product->name,
            'price' => $orderProduct->product->price,
            'image' => $orderProduct->product->image,
            'description' => $orderProduct->product->description,
            'quantity' => $orderProduct->quantity,
        ];
    }
}
