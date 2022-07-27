<?php

namespace App\UseCases\Orders;

use App\DataTransferObjects\CartDTO;
use App\Models\Orders\Order;
use App\Repositories\Orders\OrderProductRepository;
use App\Repositories\Orders\OrderRepository;
use App\UseCases\Contracts\Orders\CreateOrderUseCaseInterface;
use Exception;

class CreateOrderUseCase implements CreateOrderUseCaseInterface
{
    public function __construct(
        private OrderRepository        $orderRepository,
        private OrderProductRepository $orderProductRepository)
    {
    }

    /**
     * @throws Exception
     */
    public function handler(CartDTO $cartDTO): Order
    {
        $order = $this->orderRepository->save($cartDTO->getUserID(), $cartDTO->getTotal());

        $this->saveOrderProducts($cartDTO->getProducts(), $order->id);

        return $order;
    }

    /**
     * @throws Exception
     */
    private function saveOrderProducts(array $products, int $orderID): void
    {
        if (empty($products)) {
            throw new Exception('La orden no tiene productos');
        }

        foreach ($products as $product) {
            $this->orderProductRepository->save($orderID, $product);
        }
    }
}
