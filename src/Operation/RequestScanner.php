<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Operation;


use cebe\openapi\exceptions\TypeErrorException;
use ReflectionClass;
use Yoldi\Swagger\Attribute\Request;
use Yoldi\Swagger\Util\AttributeUtil;
use Yoldi\Swagger\Util\SchemeUtil;

class RequestScanner
{

    /**
     * @param ReflectionClass $class
     * @return array|null
     * @throws TypeErrorException
     */
    public function scan(ReflectionClass $class): ?array
    {
        if (!AttributeUtil::has(Request::class, $class)) return null;
        $request = AttributeUtil::single(Request::class, $class);
        return $this->toSpec($request);
    }

    /**
     * @param Request $request
     * @return array
     * @throws TypeErrorException
     */
    public function toSpec(Request $request): array
    {
        return [
            "content" => [
                "application/json" => [
                    "schema" => SchemeUtil::ref($request->schema)
                ]
            ]
        ];
    }
}