<?php

namespace App\Repositories\Contracts\Products;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getAllProducts(): Collection;

    public function findByID(int $productID): Product;
}
