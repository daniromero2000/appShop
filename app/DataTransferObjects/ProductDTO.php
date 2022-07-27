<?php

namespace App\DataTransferObjects;

class ProductDTO
{
    private int $productID;

    private int $quantity;

    private float $price;

    public function getProductID(): int
    {
        return $this->productID;
    }

    public function setProductID(int $productID): ProductDTO
    {
        $this->productID = $productID;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): ProductDTO
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): ProductDTO
    {
        $this->price = $price;
        return $this;
    }
}
