<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\TestSpec;

use Yoldi\Swagger\Attribute\Property;
use Yoldi\Swagger\Attribute\Schema;

/**
 * @psalm-suppress all
 */
#[Schema]
class TestSchema
{

    #[Property(schema: TestSchema2::class)]
    public $item;

    public string $type;

    public TestSchema2 $schema2;

    public bool $boolean;

    public int $integer;

    public float $float;

    public ?int $integerNull;

    public ?TestSchema2 $schemaNull;

}