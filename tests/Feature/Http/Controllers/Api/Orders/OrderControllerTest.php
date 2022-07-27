<?php

namespace Http\Controllers\Api\Orders;

use App\Models\Products\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    private const API_ORDER = 'api/order/';

    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::create([
            'name' => 'Daniel',
            'email' => 'admin@app.com',
            'password' => bcrypt('secret')
        ]);

        $this->token = 'Bearer ' . JWTAuth::fromUser($user);
    }

    public function testFormError()
    {
        $headers = array_merge([
            'Authorization' => $this->token,
        ]);

        $response = $this->post(self::API_ORDER, ["cart" => [[]]], $headers);

        $expect = [
            "errors" => [
                [
                    "status" => "400",
                    "title" => "Error in Field",
                    "detail" => "The cart.0.id field is required.",
                    "code" => "FORM_ERROR",
                    "source" => [
                        "parameter" => "cart.0.id"
                    ]
                ],
                [
                    "status" => "400",
                    "title" => "Error in Field",
                    "detail" => "The cart.0.attributes.price field is required.",
                    "code" => "FORM_ERROR",
                    "source" => [
                        "parameter" => "cart.0.attributes.price"
                    ]
                ],
                [
                    "status" => "400",
                    "title" => "Error in Field",
                    "detail" => "The cart.0.quantity field is required.",
                    "code" => "FORM_ERROR",
                    "source" => [
                        "parameter" => "cart.0.quantity"
                    ]
                ]
            ]
        ];

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJson($expect);
    }

    public function testCreateOrderSuccess()
    {
        $product1 = Product::create([
            'name' => 'Ceviche vegetariano',
            'description' => 'admin@app.com',
            'image' => 'test',
            'price' => 10_000.00
        ]);

        $product2 = Product::create([
            'name' => 'Empanadas de atún y choclo',
            'description' => 'admin@app.com',
            'image' => 'test',
            'price' => 10_000.00
        ]);

        $data = [
            "cart" => [
                [
                    "type" => "products",
                    "id" => $product1->id,
                    "attributes" => [
                        "name" => $product1->name,
                        "price" => "10000",
                        "image" => "https://t1.rg.ltmcdn.com/es/posts/0/6/0/ceviche_vegetariano_76060_600.jpg",
                        "description" => "El ceviche es uno de los platillos favoritos para disfrutar durante el verano gracias a su frescura y delicioso sabor. Generalmente, se prepara con ingredientes del mar, como por ejemplo: pescado, pulpo, camarón, entre otros, pero si sigues una dieta vegetariana, también puedes disfrutar de un rico ceviche. Por este motivo, te ofrecemos una deliciosa receta de ceviche vegetariano, una elaboración inspirada en los ceviches más tradicionales, pero hecho con verduras y lentejas."
                    ],
                    "quantity" => 1
                ],
                [
                    "type" => "products",
                    "id" => $product2->id,
                    "attributes" => [
                        "name" => $product2->name,
                        "price" => "10000",
                        "image" => "https://t2.rg.ltmcdn.com/es/posts/7/4/0/empanadas_de_atun_y_choclo_76047_600.jpg",
                        "description" => "El atún es una proteína muy nutritiva, ya que aporta grasas saludables que previenen enfermedades cardiovasculares. Además, comparado con carnes, como la vaca, pollo o cerdo, esta que te proponemos tiene menos calorías. Asimismo, son ideales para quienes buscan bajar de peso o comer de forma saludable. Por su parte, el choclo es un vegetal muy alto en fibra que aporta mucha saciedad."
                    ],
                    "quantity" => 2
                ],
            ]
        ];

        $headers = array_merge([
            'Authorization' => $this->token,
        ]);

        $response = $this->post(self::API_ORDER, $data, $headers);

        $expect = [
            "data" => [
                "type" => "order",
                "attributes" => [
                    "total" => 30000,
                    "status" => "Pending"
                ],
                "relationships" => [
                    "products" => [
                        "data" => [
                            [
                                "type" => "products",
                            ],
                            [
                                "type" => "products",
                            ]
                        ]
                    ]
                ]
            ],
            "included" => [
                [
                    "type" => "products",
                    "attributes" => [
                        "name" => "Ceviche vegetariano",
                        "price" => 10000,
                        "image" => "test",
                        "description" => "admin@app.com",
                        "quantity" => "1"
                    ]
                ],
                [
                    "type" => "products",
                    "attributes" => [
                        "name" => "Empanadas de atún y choclo",
                        "price" => 10000,
                        "image" => "test",
                        "description" => "admin@app.com",
                        "quantity" => "2"
                    ]
                ]
            ]
        ];

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson($expect);
    }
}
