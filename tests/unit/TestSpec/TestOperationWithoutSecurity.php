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
use Yoldi\Swagger\Attribute\Security;

#[Operation(path: '/without-security', method: Operation::METHOD_POST, operationId: 'testWithoutSecurity', tags: 'TestTag')]
#[Response(code: 200, description: 'OK123', schema: TestSchema::class)]
#[Request(schema: TestSchema2::class)]
class TestOperationWithoutSecurity
{

}