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

class GetProductController extends Controller
{
    public function __construct(
        private JsonApiResponseInterface $jsonResponse,
        private HttpObject $httpObject,
        private ProductTransformer $productTransformer,
        private ProductRepository $productRepository,
        private ProductsResponse $errorResponse
    )
    {
    }

    public function __invoke(int $id): JsonResponse
    {
        try {
            $this->httpObject->setItem($this->productRepository->findByID($id));

            return $this->jsonResponse->responseWithItem(
                $this->httpObject,
                $this->productTransformer,
                'product'
            );
        } catch (Throwable $th) {
            return $this->errorResponse->handle($th);
        }
     }
}
