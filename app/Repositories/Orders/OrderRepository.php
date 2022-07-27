<?php

namespace App\Repositories\Orders;

use App\Models\Orders\Order;
use App\Repositories\Contracts\Orders\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function save(int $userID, int $total): Order
    {
        $order = new Order();
        $order->user_id = $userID;
        $order->status = 'Pending';
        $order->total = $total;
        $order->save();

        return $order;
    }

    public function update(Order $order): bool
    {
        return $order->save();
    }
}
