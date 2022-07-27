<?php

namespace UseCases\Orders;

use App\Deserializers\CartDeserializer;
use App\UseCases\Orders\CreateOrderUseCase;
use Exception;
use Tests\TestCase;

class CreateOrderUseCaseTest extends TestCase
{
    private const USER_ID = 1;

    /**
     * @throws Exception
     */
    public function testCreateOrderSuccess(): void
    {
        $cartDTO = (new CartDeserializer())->deserialize(
            [
                [
                    "type" => "products",
                    "id" => self::USER_ID,
                    "attributes" => [
                        "name" => 'test1',
                        "price" => "10000",
                        "image" => "https://t1.rg.ltmcdn.com/es/posts/0/6/0/ceviche_vegetariano_76060_600.jpg",
                        "description" => "El ceviche es uno de los platillos favoritos para disfrutar durante el verano gracias a su frescura y delicioso sabor. Generalmente, se prepara con ingredientes del mar, como por ejemplo: pescado, pulpo, camarón, entre otros, pero si sigues una dieta vegetariana, también puedes disfrutar de un rico ceviche. Por este motivo, te ofrecemos una deliciosa receta de ceviche vegetariano, una elaboración inspirada en los ceviches más tradicionales, pero hecho con verduras y lentejas."
                    ],
                    "quantity" => self::USER_ID
                ],
                [
                    "type" => "products",
                    "id" => 2,
                    "attributes" => [
                        "name" => 'test2',
                        "price" => "10000",
                        "image" => "https://t2.rg.ltmcdn.com/es/posts/7/4/0/empanadas_de_atun_y_choclo_76047_600.jpg",
                        "description" => "El atún es una proteína muy nutritiva, ya que aporta grasas saludables que previenen enfermedades cardiovasculares. Además, comparado con carnes, como la vaca, pollo o cerdo, esta que te proponemos tiene menos calorías. Asimismo, son ideales para quienes buscan bajar de peso o comer de forma saludable. Por su parte, el choclo es un vegetal muy alto en fibra que aporta mucha saciedad."
                    ],
                    "quantity" => 2
                ]
            ],
            self::USER_ID
        );

        /** @var CreateOrderUseCase $useCase */
        $useCase = app(CreateOrderUseCase::class);

        $useCase->handler(
            $cartDTO
        );

        $this->assertTrue(true);
    }

    /**
     * @throws Exception
     */
    public function testCreateOrderNotProductsException(): void
    {
        $products = [];
        $cartDTO = (new CartDeserializer())->deserialize($products, self::USER_ID);

        /** @var CreateOrderUseCase $useCase */
        $useCase = app(CreateOrderUseCase::class);

        $this->expectException(Exception::class);
        $useCase->handler(
            $cartDTO
        );
    }
}
