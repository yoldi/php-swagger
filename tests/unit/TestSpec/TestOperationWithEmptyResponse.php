<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\TestSpec;


use Yoldi\Swagger\Attribute\Operation;
use Yoldi\Swagger\Attribute\Request;
use Yoldi\Swagger\Attribute\Response;

#[Operation(path: '/empty-response', method: Operation::METHOD_POST, operationId: 'emptyResponse', tags: 'TestTag')]
#[Response(code: 200, description: 'OK')]
#[Request(schema: TestSchema2::class)]
class TestOperationWithEmptyResponse
{

}