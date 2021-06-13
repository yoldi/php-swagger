<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Schema\Property;


use cebe\openapi\exceptions\TypeErrorException;
use cebe\openapi\spec\Reference as OAReference;
use cebe\openapi\spec\Schema as OASchema;
use ReflectionClass as CoreReflectionClass;
use ReflectionProperty as CoreReflectionProperty;
use Yoldi\Swagger\Schema\Property\AttributeProperty\AttributePropertyFactory;
use Yoldi\Swagger\Schema\Property\TypedProperty\TypedPropertyFactory;

class PropertyFactory
{

    private TypedPropertyFactory $typedPropertyFactory;
    private AttributePropertyFactory $attributePropertyFactory;

    public function __construct()
    {
        $this->typedPropertyFactory = new TypedPropertyFactory();
        $this->attributePropertyFactory = new AttributePropertyFactory();
    }

    /**
     * @param CoreReflectionClass $class
     * @return array
     * @throws TypeErrorException
     */
    public function create(CoreReflectionClass $class): array
    {
        $properties = $class->getProperties();

        /** @var array<string,OASchema|OAReference> $schemaProperties */
        $schemaProperties = [];

        foreach ($properties as $property) {
            $schemaProperties[$property->getName()] = $this->build($property);
        }
        return $schemaProperties;
    }

    /**
     * @param CoreReflectionProperty $property
     * @return OASchema|OAReference
     * @throws TypeErrorException
     */
    private function build(CoreReflectionProperty $property): OASchema|OAReference
    {
        if ($property->getType() !== null) {
            return $this->typedPropertyFactory->create($property);
        }
        return $this->attributePropertyFactory->create($property);
    }

}