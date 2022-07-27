<?php

namespace App\Repositories\Orders;

use App\DataTransferObjects\ProductDTO;
use App\Models\Orders\OrderProduct;
use App\Repositories\Contracts\Orders\OrderProductRepositoryInterface;

class OrderProductRepository implements OrderProductRepositoryInterface
{
    public function save(int $orderID, ProductDTO $product): OrderProduct
    {
        $orderProduct = new OrderProduct();
        $orderProduct->product_id = $product->getProductID();
        $orderProduct->order_id = $orderID;
        $orderProduct->quantity = $product->getQuantity();
        $orderProduct->save();

        return $orderProduct;
    }
}
