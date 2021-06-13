<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\TestSpec;


use Yoldi\Swagger\Attribute\Operation;
use Yoldi\Swagger\Attribute\Parameter;
use Yoldi\Swagger\Attribute\Request;
use Yoldi\Swagger\Attribute\Response;
use Yoldi\Swagger\Attribute\Security;

#[Operation(path: '/with-parameters/{id}/{method}', method: Operation::METHOD_POST, operationId: 'withParameters', tags: 'TestTag')]
#[Parameter(name: 'id', in: Parameter::IN_PATH, type: 'string', required: true)]
#[Parameter(name: 'method', in: Parameter::IN_PATH, type: 'string', required: true)]
#[Parameter(name: 'query', in: Parameter::IN_QUERY, type: 'string')]
#[Response(code: 200, description: 'OK123', schema: TestSchema::class)]
#[Request(schema: TestSchema2::class)]
#[Security]
class TestOperationWithParameters
{

}