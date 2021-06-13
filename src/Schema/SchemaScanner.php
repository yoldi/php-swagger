<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Schema;


use cebe\openapi\exceptions\TypeErrorException;
use cebe\openapi\spec\Schema as OASchema;
use ReflectionClass;
use Yoldi\Swagger\Attribute\Schema;
use Yoldi\Swagger\Schema\Property\PropertyFactory;
use Yoldi\Swagger\Util\AttributeUtil;

class SchemaScanner
{
    private PropertyFactory $propertyFactory;

    public function __construct()
    {
        $this->propertyFactory = new PropertyFactory();
    }

    /**
     * @param ReflectionClass[] $classes
     * @return array<string,OASchema>
     * @throws TypeErrorException
     * @throws SchemaNameDuplicateException
     */
    public function scan(array $classes): array
    {
        $schemes = [];
        $schemaClasses = array_filter($classes, fn(ReflectionClass $class) => AttributeUtil::has(Schema::class, $class));

        foreach ($schemaClasses as $class) {
            $properties = $this->propertyFactory->create($class);
            $schemaName = $class->getShortName();
            if (isset($schemes[$schemaName])) {
                throw new SchemaNameDuplicateException();
            }
            $schemes[$schemaName] = new OASchema([
                'properties' => $properties,
                'required' => array_keys($properties),
                'type' => 'object'
            ]);
        }
        return $schemes;
    }


}