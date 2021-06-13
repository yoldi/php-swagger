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
use Roave\BetterReflection\Reflector\ClassReflector;

class PropertyType
{

    const SCALAR_TYPES = [
        'int',
        'string',
        'float',
        'bool'
    ];

    private function __construct(private string $type,
                                 private bool $nullable)
    {
    }


    public static function createFromReflection(ReflectionProperty $property): self
    {
        $reflectionType = $property->getType();
        self::assertType($reflectionType);
        $parsedType = str_replace('?', '', (string)$reflectionType);
        $nullable = $reflectionType->allowsNull();
        return new self($parsedType, $nullable);
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