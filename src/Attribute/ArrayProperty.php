<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayProperty
{

    public function __construct(public string $schema)
    {

    }
}