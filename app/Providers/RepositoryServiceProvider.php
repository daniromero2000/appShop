<?php

namespace App\Providers;

use App\Repositories\Contracts\Orders\OrderProductRepositoryInterface;
use App\Repositories\Contracts\Orders\OrderRepositoryInterface;
use App\Repositories\Contracts\Products\ProductRepositoryInterface;
use App\Repositories\Contracts\Users\UserRepositoryInterface;
use App\Repositories\Orders\OrderProductRepository;
use App\Repositories\Orders\OrderRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Users\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected array $classes = [
        OrderProductRepositoryInterface::class => OrderProductRepository::class,
        OrderRepositoryInterface::class => OrderRepository::class,
        ProductRepositoryInterface::class => ProductRepository::class,
        UserRepositoryInterface::class => UserRepository::class
    ];

    public function register()
    {
        foreach ($this->classes as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    public function provides(): array
    {
        return array_keys($this->classes);
    }
}
