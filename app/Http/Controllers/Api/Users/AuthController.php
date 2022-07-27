<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\Controller;
use App\Libraries\Responders\Contracts\JsonApiResponseInterface;
use App\Libraries\Responders\ErrorObject;
use App\Libraries\Responders\JsonApiErrorsFormatter;
use App\Repositories\Users\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(
        private UserRepository           $userRepository,
        private JsonApiResponseInterface $jsonResponse,
    )
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse
                ->respondFormError(
                    $validator->errors(),
                    Response::HTTP_BAD_REQUEST
                );
        }

        if (!$token = JWTAuth::attempt($validator->validated())) {
            return $this->userNotAuthorized();
        }

        return $this->createNewToken($token);
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|confirmed|',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse
                ->respondFormError(
                    $validator->errors(),
                    Response::HTTP_BAD_REQUEST
                );
        }

        $this->userRepository->save($request->input());

        if (!$token = JWTAuth::attempt($request->only('email', 'password'))) {
            return $this->userNotAuthorized();
        }

        return $this->createNewToken($token);
    }

    protected function createNewToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user()
        ]);
    }

    public function getUser(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function refresh(): JsonResponse
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * @return JsonResponse
     */
    public function userNotAuthorized(): JsonResponse
    {
        $errors = new JsonApiErrorsFormatter();
        $error = new ErrorObject();
        $error->setTitle('User not authorized')
            ->setCode('USER_NOT_AUTHORIZED')
            ->setStatus((string)Response::HTTP_UNAUTHORIZED);
        $errors->add($error);

        return $this->jsonResponse
            ->respondError($errors, Response::HTTP_UNAUTHORIZED);
    }
}
