<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Attribute;

use Attribute;

#[Attribute]
class Response
{
    public function __construct(
        public int $code = 200,
        public string $description = 'OK',
        /** @psalm-var class-string */
        public ?string $schema = null)
    {
    }
}