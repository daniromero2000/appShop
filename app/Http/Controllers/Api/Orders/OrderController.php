<?php

namespace App\Http\Controllers\Api\Orders;

use App\Deserializers\CartDeserializer;
use App\Http\Controllers\Api\Controller;
use App\Http\Transformers\Products\OrderTransformer;
use App\Libraries\Responders\Contracts\JsonApiResponseInterface;
use App\Libraries\Responders\HttpObject;
use App\UseCases\Orders\CreateOrderUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class OrderController extends Controller
{
    public function __construct(
        private JsonApiResponseInterface $jsonResponse,
        private HttpObject               $httpObject,
        private OrderTransformer         $productTransformer,
        private CreateOrderUseCase       $createOrderUseCase,
        private CartDeserializer $cartDeserializer
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $validator = Validator::make($request->input(), [
            'cart' => 'required|array',
            'cart.*.id' => 'required|integer|min:1',
            'cart.*.attributes.price' => 'required|integer|min:1',
            'cart.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse
                ->respondFormError(
                    $validator->errors(),
                    Response::HTTP_BAD_REQUEST
                );
        }

        try {
            $cartDTO = $this->cartDeserializer->deserialize(
                $request->input('cart'),
                auth()->user()->id
            );

            $order = $this->createOrderUseCase->handler($cartDTO);

            $this->httpObject->setItem($order);

            return $this->jsonResponse->responseWithItem(
                $this->httpObject,
                $this->productTransformer,
                'order'
            );
        } catch (Throwable $th) {
            dd($th);
        }
    }
}
