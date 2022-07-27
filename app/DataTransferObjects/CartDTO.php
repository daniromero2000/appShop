<?php

namespace App\DataTransferObjects;

class CartDTO
{
    private int $userID;

    private float $total;

    /**
     * @var array|ProductDTO[]
     */
    private array $products = [];

    public function getUserID(): int
    {
        return $this->userID;
    }

    public function setUserID(int $userID): CartDTO
    {
        $this->userID = $userID;
        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): CartDTO
    {
        $this->total = $total;
        return $this;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function pushProduct(ProductDTO $product): CartDTO
    {
        $this->products[] = $product;
        return $this;
    }
}
