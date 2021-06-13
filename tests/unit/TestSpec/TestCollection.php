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
class TestCollection
{

    /**
     * @var TestSchema2[]
     */
    public array $items;

    /**
     * TestCollection constructor.
     * @param TestSchema2[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }


}