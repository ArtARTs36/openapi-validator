<?php

namespace ArtARTs36\OpenApiValidator\Drivers;

use ArtARTs36\OpenApiValidator\ValidInfo;

interface Driver
{
    public function check(string $filePath): ValidInfo;
}
