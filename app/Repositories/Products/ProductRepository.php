<?php

namespace App\Repositories\Products;

use App\Models\Products\Product;
use App\Repositories\Contracts\Products\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts(): Collection
    {
        return Product::all();
    }

    public function findByID(int $productID): Product
    {
        return Product::findOrFail($productID);
    }
}
