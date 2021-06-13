<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\NoResponseSpec;


use Yoldi\Swagger\Attribute\Operation;
use Yoldi\Swagger\Attribute\Security;

#[Operation(path: '/no-response', method: Operation::METHOD_DELETE, operationId: 'no-response', tags: 'TestTag')]
#[Security]
class TestPost2
{

}