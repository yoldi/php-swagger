<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Schema\Property\TypedProperty;


use cebe\openapi\exceptions\TypeErrorException;
use cebe\openapi\spec\Reference as OAReference;
use cebe\openapi\spec\Schema as OASchema;
use ReflectionProperty as CoreReflectionProperty;
use Yoldi\Swagger\Util\SchemeUtil;

class TypedPropertyFactory
{
    const SPEC_SCALAR_TYPES = [
        'int' => 'integer',
        'string' => 'string',
        'float' => 'integer',
        'bool' => 'boolean'
    ];


    /**
     * @param CoreReflectionProperty $property
     * @return OASchema|OAReference
     * @throws TypeErrorException
     */
    public function create(CoreReflectionProperty $property): OASchema|OAReference
    {
        $propertyType = PropertyType::createFromReflection($property);
        if ($propertyType->isScalarType()) {
            return $this->createForScalar($propertyType);
        } else {
            return $this->createForRef($propertyType);
        }
    }

    /**
     * @param PropertyType $propertyType
     * @return OASchema|OAReference
     * @throws TypeErrorException
     */
    private function createForRef(PropertyType $propertyType): OASchema|OAReference
    {
        if ($propertyType->isNullable()) {
            return new OASchema([
                'nullable' => true,
                'oneOf' => [SchemeUtil::ref($propertyType->getType())]
            ]);
        }
        return SchemeUtil::ref($propertyType->getType());
    }

    /**
     * @param PropertyType $propertyType
     * @return OASchema
     * @throws TypeErrorException
     */
    private function createForScalar(PropertyType $propertyType): OASchema
    {
        return new OASchema([
            'nullable' => $propertyType->isNullable(),
            'type' => $this->specScalarType($propertyType)
        ]);
    }

    /**
     * @param PropertyType $propertyType
     * @return string
     */
    public function specScalarType(PropertyType $propertyType): string
    {
        return self::SPEC_SCALAR_TYPES[$propertyType->getType()];
    }
}