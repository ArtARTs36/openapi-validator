<?php

namespace ArtARTs36\OpenApiValidator\Drivers;

class DriverFactory
{
    protected const DRIVERS = [
        SwaggerTools::NAME => SwaggerTools::class,
    ];

    public static function instance(string $slug): Driver
    {
        if (! isset(static::DRIVERS[$slug])) {
            throw new \LogicException('Driver ' . $slug . ' is not supported!');
        }

        $class = static::DRIVERS[$slug];

        return new $class();
    }
}
