<?php

namespace App\Http\Responses;

use App\Libraries\Responders\Contracts\JsonApiResponseInterface;
use App\Libraries\Responders\ErrorObject;
use App\Libraries\Responders\JsonApiErrorsFormatter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

class ProductsResponse extends GeneralErrorResponse
{
    private array $awareOf = [
        ModelNotFoundException::class => 'productNotFound',
    ];

    public function __construct(
        private JsonApiResponseInterface $jsonApiResponse,
        private JsonApiErrorsFormatter $jsonErrorFormat
    ) {
        parent::__construct($jsonApiResponse);
    }

    /**
     * @see productNotFound
     */
    public function handle(Throwable $exception): JsonResponse
    {
        $className = get_class($exception);

        if (in_array($className, array_keys($this->awareOf))) {
            return $this->{$this->awareOf[$className]}($exception);
        }

        return $this->generalError();
    }

    private function productNotFound(): JsonResponse
    {
        $error = new ErrorObject();
        $error->setId('PRODUCT_NOT_FOUND')
            ->setTitle(self::TITLE_ERROR)
            ->setDetail('No se encontró el producto.')
            ->setStatus(self::HTTP_BUSINESS_ERROR_STRING);

        $this->jsonErrorFormat->add($error);

        return $this->jsonApiResponse->respondError(
            $this->jsonErrorFormat,
            self::HTTP_BUSINESS_ERROR
        );
    }
}
