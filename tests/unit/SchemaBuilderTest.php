<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger;

use cebe\openapi\exceptions\TypeErrorException;
use Codeception\Test\Unit;
use Exception;
use ReflectionException;
use Yoldi\Swagger\Declaration\ApiDeclaration;
use Yoldi\Swagger\Declaration\SecuritySchema;
use Yoldi\Swagger\Operation\NoResponseException;
use Yoldi\Swagger\Operation\OperationIdDuplicateException;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class SchemaBuilderTest extends Unit
{
    public function testSuccess(): void
    {
//        $this->markTestSkipped('Need assertions');
        $scan = new DocumentationBuilder();
        $json = $scan->build($this->declaration(), ['tests/unit/TestSpec']);
        file_put_contents('result.json',$json);
    }

    /**
     * @dataProvider exceptionDataProvider
     * @param array<array-key,string> $dirs
     * @param Exception $exception
     * @throws NoResponseException
     * @throws OperationIdDuplicateException
     * @throws Operation\PathMethodDuplicateException
     * @throws Operation\PathParameterNotFoundInPathException
     * @throws ReflectionException
     * @throws Schema\SchemaNameDuplicateException
     * @throws TypeErrorException
     */
    public function testException(array $dirs, Exception $exception): void
    {
        $scan = new DocumentationBuilder();
        $this->expectExceptionObject($exception);
        $scan->build($this->declaration(), $dirs);
    }

    public function exceptionDataProvider(): array
    {
        return [
            [
                'directories' => ['tests/unit/NoResponseSpec'],
                'exception' => new NoResponseException('There must be at least one server response.')
            ],
            [
                'directories' => ['tests/unit/DuplicateOperationId'],
                'exception' => new OperationIdDuplicateException()
            ]
        ];
    }


    private function declaration(): ApiDeclaration
    {
        return new ApiDeclaration('test', '0.0.1', [new SecuritySchema('token', 'Authorization', 'header', 'apiKey')]);
    }

}
