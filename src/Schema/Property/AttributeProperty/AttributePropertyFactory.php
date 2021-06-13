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
use Yoldi\Swagger\Attribute\Property;
use Yoldi\Swagger\Util\AttributeUtil;
use Yoldi\Swagger\Util\SchemeUtil;

class AttributePropertyFactory
{

    /**
     * @param CoreReflectionProperty $property
     * @return OASchema|OAReference
     * @throws TypeErrorException
     */
    public function create(CoreReflectionProperty $property): OASchema|OAReference
    {
        $propertyAttribute = AttributeUtil::single(Property::class, $property);
        return new OASchema([
            'nullable' => $propertyAttribute->nullable,
            'oneOf' => [SchemeUtil::ref($propertyAttribute->schema)]
        ]);
    }

}