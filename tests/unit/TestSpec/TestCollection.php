<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\TestSpec;

use Yoldi\Swagger\Attribute\ArrayProperty;
use Yoldi\Swagger\Attribute\Schema;

/**
 * @psalm-suppress all
 */
#[Schema]
class TestCollection
{

    /**
     * TestCollection constructor.
     * @param TestSchema2[] $items
     */
    public function __construct(#[ArrayProperty(schema: TestSchema2::class)] public array $items)
    {
    }


}