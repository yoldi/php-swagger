<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Util;


use cebe\openapi\exceptions\TypeErrorException;
use cebe\openapi\spec\Reference;

class SchemeUtil
{
    /**
     * @throws TypeErrorException
     */
    public static function ref(string $name): Reference
    {
        $parts = explode('\\', $name);
        $name = $parts[count($parts) - 1];
        return new Reference(['$ref' => "#/components/schemas/$name"]);
    }


}