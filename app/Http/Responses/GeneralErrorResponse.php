<?php

namespace App\Http\Responses;

use App\Libraries\Responders\Contracts\JsonApiResponseInterface;
use App\Libraries\Responders\ErrorObject;
use App\Libraries\Responders\JsonApiErrorsFormatter;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GeneralErrorResponse
{
    /**
     * Title of general error.
     */
    public const TITLE_ERROR = 'General error';

    /**
     * General error code.
     */
    public const GENERAL_ERROR = 'GENERAL_ERROR';

    /**
     * General error code.
     */
    public const DETAIL_ERROR = 'Un error inesperado ha ocurrido.';

    /**
     * Http general business error.
     */
    public const HTTP_BUSINESS_ERROR = 280;

    /**
     * Http general business error in string.
     */
    public const HTTP_BUSINESS_ERROR_STRING = '280';

    /**
     * Bad Request error code.
     */
    public const FORM_ERROR = 'FORM_ERROR';

    protected JsonApiResponseInterface $response;

    /**
     * GeneralErrorResponse constructor.
     * @param JsonApiResponseInterface $response
     */
    public function __construct(JsonApiResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return JsonResponse
     */
    public function generalError(): JsonResponse
    {
        $error = (new ErrorObject())
            ->setTitle(self::TITLE_ERROR)
            ->setCode(self::GENERAL_ERROR)
            ->setDetail(self::DETAIL_ERROR)
            ->setStatus((string) Response::HTTP_INTERNAL_SERVER_ERROR);

        $errors = (new JsonApiErrorsFormatter())
            ->add($error);

        return $this->response
            ->respondError(
                $errors,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
    }
}
