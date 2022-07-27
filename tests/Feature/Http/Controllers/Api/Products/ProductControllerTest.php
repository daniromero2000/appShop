<?php

namespace Http\Controllers\Api\Products;

use App\Models\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetProducts()
    {
        $product = Product::create([
            'name' => 'Daniel',
            'description' => 'admin@app.com',
            'image' => 'test',
            'price' => 10_000.00
        ]);

        $response = $this->get('api/products/');

        $expect = [
            'data' => [
                [
                    'type' => 'products',
                    'id' => (string) $product->id,
                    'attributes' => [
                        'name' => $product->name,
                        'price' => $product->price,
                        'description' => $product->description,
                        'image' => $product->image
                    ]
                ]
            ]
        ];

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson($expect);
    }
}
