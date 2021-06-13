<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Attribute;

use Attribute;

#[Attribute]
class PathParameter extends Parameter
{

    public function __construct(string $name, string $type)
    {
        parent::__construct($name, Parameter::IN_PATH, $type);
    }
}