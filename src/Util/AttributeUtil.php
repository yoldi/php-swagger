<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Util;

use InvalidArgumentException;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;

class AttributeUtil
{

    /**
     * @template T of object
     * @param class-string<T> $attributeClass
     * @param ReflectionProperty|ReflectionClass $reflection
     * @psalm-return T
     * @return T
     */
    public static function single(string $attributeClass, ReflectionProperty|ReflectionClass $reflection): object
    {
        $attributes = $reflection->getAttributes($attributeClass);
        if (count($attributes) !== 1) throw new InvalidArgumentException("Not attributes $attributeClass");
        return $attributes[0]->newInstance();
    }

    /**
     * @template T of object
     * @param class-string<T> $attributeClass
     * @param ReflectionProperty|ReflectionClass $reflection
     * @return array<array-key,T>
     */
    public static function all(string $attributeClass, ReflectionProperty|ReflectionClass $reflection): array
    {
        $attributes = $reflection->getAttributes($attributeClass);
        return array_map(fn(ReflectionAttribute $reflectionAttribute) => $reflectionAttribute->newInstance(), $attributes);
    }

    /**
     * @param class-string $attributeClass
     * @param ReflectionProperty|ReflectionClass $reflection
     * @return bool
     */
    public static function has(string $attributeClass, ReflectionProperty|ReflectionClass $reflection): bool
    {
        return count($reflection->getAttributes($attributeClass)) > 0;
    }
}