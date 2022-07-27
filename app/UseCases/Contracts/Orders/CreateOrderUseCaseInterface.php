<?php

namespace App\UseCases\Contracts\Orders;

use App\DataTransferObjects\CartDTO;
use App\Models\Orders\Order;

interface CreateOrderUseCaseInterface
{
    public function handler(CartDTO $cartDTO): Order;
}
