<?php

namespace Http\Controllers\Api\Products;

use App\Http\Responses\GeneralErrorResponse;
use App\Models\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class GetProductControllerTest extends TestCase
{
    use RefreshDatabase;

    const API_PRODUCT = 'api/product/';

    public function testGetProduct()
    {
        $product = Product::create([
            'name' => 'Daniel',
            'description' => 'admin@app.com',
            'image' => 'test',
            'price' => 10_000.00
        ]);

        $response = $this->get(self::API_PRODUCT . $product->id);

        $expect = [
            'data' => [
                'type' => 'product',
                'id' => (string) $product->id,
                'attributes' => [
                    'name' => $product->name,
                    'price' => $product->price,
                    'description' => $product->description,
                    'image' => $product->image
                ]
            ]
        ];

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson($expect);
    }

    public function testProductNotFound()
    {
        $response = $this->get(self::API_PRODUCT . 1);

        $expect = [
            'errors' => [
                [
                    'title' => 'General error',
                    'detail' => 'No se encontró el producto.',
                    'id' => 'PRODUCT_NOT_FOUND',
                    'status' => GeneralErrorResponse::HTTP_BUSINESS_ERROR_STRING,
                ]
            ]
        ];

        $response->assertStatus(GeneralErrorResponse::HTTP_BUSINESS_ERROR);
        $response->assertJson($expect);
    }
}
