<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Schema\Property\AttributeProperty;


use cebe\openapi\exceptions\TypeErrorException;
use cebe\openapi\spec\Reference as OAReference;
use cebe\openapi\spec\Schema as OASchema;
use ReflectionProperty as CoreReflectionProperty;
use Yoldi\Swagger\Attribute\ArrayProperty;
use Yoldi\Swagger\Attribute\Property;
use Yoldi\Swagger\Util\AttributeUtil;
use Yoldi\Swagger\Util\SchemeUtil;

class AttributePropertyFactory
{

    /**
     * @param CoreReflectionProperty $property
     * @return OASchema
     * @throws TypeErrorException
     */
    public function create(CoreReflectionProperty $property): OASchema
    {
        if (AttributeUtil::has(Property::class, $property)) {
            $propertyAttribute = AttributeUtil::single(Property::class, $property);
            return new OASchema([
                'nullable' => $propertyAttribute->nullable,
                'oneOf' => [SchemeUtil::ref($propertyAttribute->schema)]
            ]);
        }
        if (AttributeUtil::has(ArrayProperty::class, $property)) {
            $propertyAttribute = AttributeUtil::single(ArrayProperty::class, $property);
            return new OASchema([
                'type' => 'array',
                'items' => SchemeUtil::ref($propertyAttribute->schema)
            ]);
        }
    }

}