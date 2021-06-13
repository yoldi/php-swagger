<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Attribute;


use Attribute;

#[Attribute]
class Property
{
    public function __construct(public string $schema, public bool $nullable = false)
    {
    }
}