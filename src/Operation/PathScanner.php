<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Operation;


use cebe\openapi\exceptions\TypeErrorException;
use cebe\openapi\spec\Operation as OAOperation;
use ReflectionClass;
use Yoldi\Swagger\Attribute\Operation;
use Yoldi\Swagger\Util\AttributeUtil;

class PathScanner
{

    /**
     * @param ReflectionClass[] $classes
     * @return array<string,array<string,OAOperation>>
     * @throws TypeErrorException
     * @throws NoResponseException
     * @throws PathParameterNotFoundInPathException
     * @throws PathMethodDuplicateException
     * @throws OperationIdDuplicateException
     */
    public function scan(array $classes): array
    {
        $operationClasses = array_filter($classes, fn(ReflectionClass $class) => AttributeUtil::has(Operation::class, $class));

        $paths = [];
        $registeredOperationIds = [];

        foreach ($operationClasses as $class) {
            $operation = AttributeUtil::single(Operation::class, $class);

            if (in_array($operation->operationId, $registeredOperationIds)) {
                throw new OperationIdDuplicateException();
            }
            $registeredOperationIds[] = $operation->operationId;
            if (isset($paths[$operation->path][$operation->method])) {
                throw new PathMethodDuplicateException();
            }

            $oaOperation = new OAOperation(array_filter([
                'tags' => $operation->tags,
                'operationId' => $operation->operationId,
                'requestBody' => (new RequestScanner())->scan($class),
                'security' => (new SecurityScanner())->scan($class),
                'parameters' => (new ParametersScanner())->scan($class),
                'responses' => (new ResponsesScanner())->scan($class)
            ]));


            $paths[$operation->path] = [$operation->method => $oaOperation];
        }

        return $paths;
    }

}