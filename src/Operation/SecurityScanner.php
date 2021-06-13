<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Operation;


use ReflectionClass;
use Yoldi\Swagger\Attribute\Security;
use Yoldi\Swagger\Util\AttributeUtil;

class SecurityScanner
{

    /**
     * @param ReflectionClass $class
     * @return array
     */
    public function scan(ReflectionClass $class): array
    {
        $security = AttributeUtil::all(Security::class, $class);
        return array_map(fn(Security $security) => $this->toSpec($security), $security);
    }

    /**
     * @param Security $security
     * @return array[]
     */
    private function toSpec(Security $security): array
    {
        return [$security->name => []];
    }
}