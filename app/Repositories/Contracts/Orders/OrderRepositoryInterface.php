<?php

namespace App\Repositories\Contracts\Orders;

use App\Models\Orders\Order;

interface OrderRepositoryInterface
{
    public function save(int $userID, int $total): Order;

    public function update(Order $order): bool;
}
