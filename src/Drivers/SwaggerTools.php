<?php

namespace ArtARTs36\OpenApiValidator\Drivers;

use ArtARTs36\OpenApiValidator\ValidInfo;

class SwaggerTools implements Driver
{
    public const NAME = 'swagger_tools';

    public function check(string $filePath): ValidInfo
    {
        $result = shell_exec($this->compileCommand($filePath));

        $matches = [];

        preg_match('/(\d{1,}) errors and (\d{1,}) warnings/i', $result, $matches);

        if (count($matches) !== 3) {
            throw new \LogicException('Failed to parse response SwaggerTools');
        }

        //

        $counters = array_map('intval', array_slice($matches, 1, 2));

        return new ValidInfo($counters[0], $counters[1], (array) $result);
    }

    protected function compileCommand(string $path): string
    {
        return 'swagger-tools validate '. $path .' 2>&1';
    }
}
