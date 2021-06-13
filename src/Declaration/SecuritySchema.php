<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Declaration;


class SecuritySchema
{
    public function __construct(public string $schemaName, public string $name, public string $in, public string $type)
    {
    }
}