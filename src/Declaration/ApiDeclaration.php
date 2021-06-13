<?php /** @noinspection ALL */
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Declaration;


class ApiDeclaration
{

    /**
     * ApiDeclaration constructor.
     * @param SecuritySchema[] $securitySchemes
     */
    public function __construct(public string $name, public string $version, public array $securitySchemes = [], public string $description = '')
    {
    }
}