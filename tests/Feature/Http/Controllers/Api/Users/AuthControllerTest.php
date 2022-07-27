<?php

namespace Http\Controllers\Api\Users;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    private const API_LOGIN = '/api/login';
    private const API_REGISTER = '/api/register';

    public function testFormErrorLogin()
    {
        $response = $this->post(self::API_LOGIN,);

        $expect =  [
            "errors" => [
                [
                    "status" => "400",
                    "title" => "Error in Field",
                    "detail" => "The email field is required.",
                    "code" => "FORM_ERROR",
                    "source" => [
                        "parameter" => "email"
                    ]
                ],
                [
                    "status" => "400",
                    "title" => "Error in Field",
                    "detail" => "The password field is required.",
                    "code" => "FORM_ERROR",
                    "source" => [
                        "parameter" => "password"
                    ]
                ]
            ]
        ];;

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJson($expect);
    }

    public function testFormErrorRegister()
    {
        $response = $this->post(self::API_REGISTER,);

        $expect = [
            "errors" => [
                [
                    "status" => "400",
                    "title" => "Error in Field",
                    "detail" => "The name field is required.",
                    "code" => "FORM_ERROR",
                    "source" => [
                        "parameter" => "name"
                    ]
                ],
                [
                    "status" => "400",
                    "title" => "Error in Field",
                    "detail" => "The email field is required.",
                    "code" => "FORM_ERROR",
                    "source" => [
                        "parameter" => "email"
                    ]
                ],
                [
                    "status" => "400",
                    "title" => "Error in Field",
                    "detail" => "The password field is required.",
                    "code" => "FORM_ERROR",
                    "source" => [
                        "parameter" => "password"
                    ]
                ]
            ]
        ];

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJson($expect);
    }

    /**
     * User may want to register.
     * This route should be free for all unauthenticated users.
     * User should receive an JWT token
     */
    public function testRegisterSuccess()
    {
        $data = [
            "name" => "artyom developer",
            "password" => "123456",
            "password_confirmation" => "123456",
            "email" => "desarrollo@correo.com"
        ];

        $response = $this->post(self::API_REGISTER, $data);
        $content = json_decode($response->getContent());

        $response->assertStatus(Response::HTTP_OK);
        $this->assertObjectHasAttribute('access_token', $content);
        $this->assertNotEmpty($content->access_token);
    }

    /**
     * User may want to login, but using wrong credentials.
     * This route should be free for all unauthenticated users.
     * Users should be warned when login fails
     */
    public function testLoginWithWrongData()
    {
        $data = ['email' => 'email@correo.com', 'password' => 'password'];

        $response = $this->post(self::API_LOGIN, $data);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * User may want to login.
     * This route should be free for all unauthenticated users.
     * User should receive an JWT token
     */
    public function testLoginSuccess()
    {
        User::create([
            'name' => 'Daniel',
            'email' => 'admin@app.com',
            'password' => bcrypt('secret')
        ]);

        $data = [
            'email' => 'admin@app.com',
            'password' => 'secret'
        ];

        $response = $this->post(self::API_LOGIN, $data);
        $content = json_decode($response->getContent());

        $response->assertStatus(Response::HTTP_OK);
        $this->assertObjectHasAttribute('access_token', $content);
        $this->assertNotEmpty($content->access_token);
    }
}
