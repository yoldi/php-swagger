<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger;


use cebe\openapi\exceptions\TypeErrorException;
use cebe\openapi\spec\Components;
use cebe\openapi\spec\Info;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Paths;
use cebe\openapi\spec\SecurityScheme;
use ReflectionException;
use Yoldi\Swagger\Declaration\ApiDeclaration;
use Yoldi\Swagger\Operation\PathScanner;
use Yoldi\Swagger\Schema\SchemaScanner;

class DocumentationBuilder
{


    /**
     * @param ApiDeclaration $apiDeclaration
     * @param string[] $directories
     * @return string
     * @throws Operation\NoResponseException
     * @throws Operation\OperationIdDuplicateException
     * @throws Operation\PathMethodDuplicateException
     * @throws Operation\PathParameterNotFoundInPathException
     * @throws ReflectionException
     * @throws Schema\SchemaNameDuplicateException
     * @throws TypeErrorException
     */
    public function build(ApiDeclaration $apiDeclaration, array $directories): string
    {
        $classes = (new ClassScanner())->scan($directories);

        $openApi = new OpenApi([
            'openapi' => '3.0.0',
            'info' => new Info([
                'version' => $apiDeclaration->version,
                'title' => $apiDeclaration->name,
                'description' => $apiDeclaration->description
            ]),
        ]);

        $openApi->components = new Components([
            'schemas' => (new SchemaScanner())->scan($classes),
            'securitySchemes' => $this->securitySchemes($apiDeclaration)
        ]);
        $openApi->paths = new Paths((new PathScanner())->scan($classes));

        return json_encode($openApi->getSerializableData(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @return array<string,SecurityScheme>
     * @throws TypeErrorException
     */
    private function securitySchemes(ApiDeclaration $apiDeclaration): array
    {
        $securitySchemes = [];
        foreach ($apiDeclaration->securitySchemes as $securitySchema) {
            $securitySchemes[$securitySchema->schemaName] = new SecurityScheme([
                "type" => $securitySchema->type,
                "name" => $securitySchema->name,
                "in" => $securitySchema->in
            ]);
        }
        return $securitySchemes;
    }
}