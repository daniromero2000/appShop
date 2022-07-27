<?php

namespace Database\Seeders;

use App\Models\Products\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Product::create(
            [
                'name' => 'Ceviche vegetariano',
                'description' => 'El ceviche es uno de los platillos favoritos para disfrutar durante el verano gracias a su frescura y delicioso sabor. Generalmente, se prepara con ingredientes del mar, como por ejemplo: pescado, pulpo, camarón, entre otros, pero si sigues una dieta vegetariana, también puedes disfrutar de un rico ceviche. Por este motivo, te ofrecemos una deliciosa receta de ceviche vegetariano, una elaboración inspirada en los ceviches más tradicionales, pero hecho con verduras y lentejas.',
                'image' => 'https://t1.rg.ltmcdn.com/es/posts/0/6/0/ceviche_vegetariano_76060_600.jpg',
                'price' => 10_000
            ]
        );

        Product::create(
            [
                'name' => 'Empanadas de atún y choclo',
                'description' => 'El atún es una proteína muy nutritiva, ya que aporta grasas saludables que previenen enfermedades cardiovasculares. Además, comparado con carnes, como la vaca, pollo o cerdo, esta que te proponemos tiene menos calorías. Asimismo, son ideales para quienes buscan bajar de peso o comer de forma saludable. Por su parte, el choclo es un vegetal muy alto en fibra que aporta mucha saciedad.',
                'image' => 'https://t2.rg.ltmcdn.com/es/posts/7/4/0/empanadas_de_atun_y_choclo_76047_600.jpg',
                'price' => 10_000
            ]
        );

        Product::create(
            [
                'name' => 'Tacos dorados de atún',
                'description' => 'En ocasiones, las ideas se acaban a la hora de cocinar y tratamos de estirar el bolsillo para encontrar recetas económicas y rendidoras. Por este motivo, os presentamos los tacos dorados, una muy buena opción cuando queremos ahorrar un poco sin dejar de lado un platillo rico y muy completo.',
                'image' => 'https://t2.rg.ltmcdn.com/es/posts/0/2/0/tacos_dorados_de_atun_76020_600.jpg',
                'price' => 10_000
            ]
        );

        Product::create(
            [
                'name' => 'Granizado de naranja',
                'description' => 'El granizado de naranja consiste en una deliciosa bebida rica, fresquita y natural para el verano. Además, es muy fácil de preparar, con tan solo tres ingredientes lo tendrás listo. Incluso, si te sobra, podrás guardarlo en el congelador para los momentos más calurosos.',
                'image' => 'https://t2.rg.ltmcdn.com/es/posts/2/4/0/granizado_de_naranja_76042_600.jpg',
                'price' => 20_000
            ]
        );

        Product::create(
            [
                'name' => 'Pizza de calabaza',
                'description' => '¿Sabías que la masa de pizza también puede incluir patata, calabaza o cualquier otro vegetal? De esta forma, adquiere un sabor totalmente diferente, lo que nos permite disfrutar de pizzas mucho más sabrosas y originales, a la vez que saludables.',
                'image' => 'https://t1.rg.ltmcdn.com/es/posts/6/1/1/pizza_de_calabaza_75116_600.jpg',
                'price' => 15_000
            ]
        );

        Product::create(
            [
                'name' => 'Ropa vieja de res',
                'description' => 'La elaboración de ropa vieja consiste en un guiso popular en Cuba, México, Guatemala y otros países de América Central y del sur. Se trata de un platillo con carne de res deshebrada y guisada con salsa de tomate y diferentes ingredientes, como por ejemplo: papa, zanahoria, aceitunas, chiles, entre otros. También debes saber que el nombre hace referencia a los hilos de la ropa vieja cubana o mexicana, también se conoce como hilacha de res.',
                'image' => 'https://t1.rg.ltmcdn.com/es/posts/5/4/0/ropa_vieja_de_res_76045_600.jpg',
                'price' => 22_000
            ]
        );
    }
}
