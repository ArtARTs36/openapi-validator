<?php

namespace ArtARTs36\OpenApiValidator;

use ArtARTs36\OpenApiValidator\Drivers\Driver;

class Validator
{
    protected $driver;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    public function valid(string $filePath): ValidInfo
    {
        return $this->driver->check($filePath);
    }
}
