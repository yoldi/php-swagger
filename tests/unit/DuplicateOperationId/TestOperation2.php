<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\DuplicateOperationId;


use Yoldi\Swagger\Attribute\Operation;
use Yoldi\Swagger\Attribute\Response;

#[Operation(path: '/two', method: Operation::METHOD_POST, operationId: 'dup', tags: 'TestTag')]
#[Response(code: 200, description: 'OK')]
class TestOperation2
{

}