<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Schema\Property\TypedProperty;


use InvalidArgumentException;
use ReflectionProperty;
use ReflectionType;
use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflection\ReflectionProperty as BetterReflectionProperty;
use Roave\BetterReflection\Reflector\ClassReflector;

class PropertyType
{
    private static ?ClassReflector $classReflector = null;

    const SCALAR_TYPES = [
        'int',
        'string',
        'float',
        'bool'
    ];

    private function __construct(private string $type,
                                 private bool $array,
                                 private bool $nullable)
    {
    }


    public static function createFromReflection(ReflectionProperty $property): self
    {
        $reflectionType = $property->getType();
        self::assertType($reflectionType);
        $parsedType = str_replace('?', '', (string)$reflectionType);
        $array = $parsedType === 'array';
        $type = $array ? static::resolveArrayType($property) : $parsedType;
        $nullable = $reflectionType->allowsNull();
        return new self($type, $array, $nullable);
    }

    /**
     * @param ReflectionProperty $property
     * @return string
     */
    private static function resolveArrayType(ReflectionProperty $property): string
    {
        if (self::$classReflector === null) {
            self::$classReflector = (new BetterReflection())->classReflector();
        }
        $properties = self::$classReflector->reflect($property->getDeclaringClass()->getName())->getProperties();
        $property = array_values(array_filter($properties, fn(BetterReflectionProperty $pr) => $pr->getName() === $property->getName()))[0];
        return str_replace('[]', '', $property->getDocBlockTypeStrings()[0]);
    }

    /**
     * @codeCoverageIgnore
     * @param ReflectionType|null $reflectionType
     */
    private static function assertType(?ReflectionType $reflectionType): void
    {
        if ($reflectionType === null) {
            throw new InvalidArgumentException('Property doesnt have type');
        }
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isArray(): bool
    {
        return $this->array;
    }

    /**
     * @return bool
     */
    public function isScalarType(): bool
    {
        return in_array($this->type, self::SCALAR_TYPES);
    }

    /**
     * @return bool
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }


}