<?php

namespace App\Deserializers;

use App\DataTransferObjects\CartDTO;
use App\DataTransferObjects\ProductDTO;

class CartDeserializer
{
    public function deserialize(array $cart, int $userID): CartDTO
    {
        $total = 0.00;
        $cartDTO = (new CartDTO())->setUserID($userID);

        foreach ($cart as $product) {
            $productDTO = (new ProductDTO())
                ->setProductID($product['id'])
                ->setQuantity($product['quantity'])
                ->setPrice($product['attributes']['price']);

            $cartDTO->pushProduct($productDTO);
            $total += $productDTO->getPrice() * $productDTO->getQuantity();
        }

        $cartDTO->setTotal($total);

        return $cartDTO;
    }
}
