<?php

namespace App\Providers;

use App\UseCases\Contracts\Orders\CreateOrderUseCaseInterface;
use App\UseCases\Orders\CreateOrderUseCase;
use Illuminate\Support\ServiceProvider;

class UseCaseServiceProvider extends ServiceProvider
{
    protected array $classes = [
        CreateOrderUseCaseInterface::class => CreateOrderUseCase::class
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
