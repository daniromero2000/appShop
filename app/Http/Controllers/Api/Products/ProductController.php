<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Api\Controller;
use App\Http\Responses\ProductsResponse;
use App\Http\Transformers\Products\ProductTransformer;
use App\Libraries\Responders\Contracts\JsonApiResponseInterface;
use App\Libraries\Responders\HttpObject;
use App\Repositories\Products\ProductRepository;
use Illuminate\Http\JsonResponse;
use Throwable;

class ProductController extends Controller
{
    public function __construct(
        private JsonApiResponseInterface $jsonResponse,
        private HttpObject               $httpObject,
        private ProductTransformer       $productTransformer,
        private ProductRepository        $productRepository,
        private ProductsResponse         $errorResponse
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        try {
            $this->httpObject->setCollection(
                $this->productRepository->getAllProducts()
            );

            return $this->jsonResponse->respondWithCollection(
                $this->httpObject,
                $this->productTransformer,
                'products'
            );
        } catch (Throwable $th) {
            return $this->errorResponse->handle($th);
        }
    }
}
