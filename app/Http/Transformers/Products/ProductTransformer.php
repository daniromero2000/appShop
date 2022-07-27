<?php

namespace App\Http\Transformers\Products;

use App\Models\Products\Product;
use League\Fractal\TransformerAbstract;

/**
 * Class ProductTransformer
 */
class ProductTransformer extends TransformerAbstract
{
    /**
     * @param Product $product
     * @return array
     */
    public function transform(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'description' => $product->description
        ];
    }
}
