<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Attribute;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS)]
class Parameter
{

    const IN_PATH = 'path';
    const IN_QUERY = 'query';

    /**
     * Parameter constructor.
     * @psalm-param self::IN_PATH|self::IN_QUERY $in
     * @param string $name
     * @param string $in
     * @param string $type
     * @param bool $required
     */
    public function __construct(public string $name, public string $in, public string $type, public bool $required = true)
    {
    }

}