<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Attribute;

use Attribute;

#[Attribute]
class Operation
{
    const METHOD_POST = 'post';
    const METHOD_GET = 'get';
    const METHOD_PATCH = 'patch';
    const METHOD_DELETE = 'delete';

    public array $tags;

    /**
     * Operation constructor.
     * @psalm-param self::METHOD_POST|self::METHOD_GET|self::METHOD_PATCH|self::METHOD_DELETE $method
     * @param string $path
     * @param string $method
     * @param string $operationId
     * @param array|string $tags
     */
    public function __construct(public string $path, public string $method, public string $operationId, array|string $tags)
    {
        $this->tags = is_array($tags) ? $tags : [$tags];
    }
}