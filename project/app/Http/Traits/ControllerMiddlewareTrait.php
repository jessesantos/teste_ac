<?php

namespace App\Http\Traits;

trait ControllerMiddlewareTrait
{
    /**
     * The middleware registered on the controller.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * Register middleware on the controller.
     *
     * @param  \Closure|array|string  $middleware
     * @param  array  $options
     * @return $this
     */
    public function middleware($middleware, array $options = [])
    {
        // No Laravel 11, este método foi removido
        // Não faz nada, apenas retorna $this para evitar erros
        return $this;
    }
} 