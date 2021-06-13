<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Operation;


use cebe\openapi\exceptions\TypeErrorException;
use cebe\openapi\spec\Parameter as OAParameter;
use cebe\openapi\spec\Schema as OASchema;
use ReflectionClass;
use Yoldi\Swagger\Attribute\Operation;
use Yoldi\Swagger\Attribute\Parameter;
use Yoldi\Swagger\Util\AttributeUtil;

class ParametersScanner
{

    /**
     * @param ReflectionClass $class
     * @return array<OAParameter>
     * @throws PathParameterNotFoundInPathException
     * @throws TypeErrorException
     */
    public function scan(ReflectionClass $class): array
    {
        $operation = AttributeUtil::single(Operation::class, $class);
        $params = AttributeUtil::all(Parameter::class, $class);
        return array_map(fn(Parameter $parameter) => $this->create($parameter, $operation), $params);
    }

    /**
     * @throws PathParameterNotFoundInPathException
     * @throws TypeErrorException
     */
    public function create(Parameter $parameter, Operation $operation): OAParameter
    {
        if ($parameter->in === 'path' && strstr($operation->path, '{' . $parameter->name . '}') === false) {
            throw new PathParameterNotFoundInPathException();
        }
        return $this->toSpec($parameter);
    }

    /**
     * @param Parameter $parameter
     * @return OAParameter
     * @throws TypeErrorException
     */
    public function toSpec(Parameter $parameter): OAParameter
    {
        return new OAParameter([
            'name' => $parameter->name,
            'in' => $parameter->in,
            'required' => $parameter->required,
            'schema' => new OASchema([
                'type' => $parameter->type
            ])
        ]);
    }

}