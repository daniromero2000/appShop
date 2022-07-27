<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail(int $productID)
 * @method static create(array $array)
 */
class Product extends Model
{
    protected $fillable = [
        'name', 'image', 'description', 'price'
    ];
}
