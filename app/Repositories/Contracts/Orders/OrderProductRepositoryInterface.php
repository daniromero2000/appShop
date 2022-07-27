<?php

namespace App\Repositories\Contracts\Orders;

use App\DataTransferObjects\ProductDTO;
use App\Models\Orders\OrderProduct;

interface OrderProductRepositoryInterface
{
    public function save(int $orderID, ProductDTO $product): OrderProduct;
}
