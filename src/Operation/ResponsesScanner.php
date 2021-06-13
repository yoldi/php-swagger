<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger\Operation;


use cebe\openapi\exceptions\TypeErrorException;
use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\Response as OAResponse;
use ReflectionClass;
use Yoldi\Swagger\Attribute\Response;
use Yoldi\Swagger\Util\AttributeUtil;
use Yoldi\Swagger\Util\SchemeUtil;

class ResponsesScanner
{

    /**
     * @param ReflectionClass $class
     * @return array<int,OAResponse>
     * @throws NoResponseException
     * @throws TypeErrorException
     */
    public function scan(ReflectionClass $class): array
    {
        if (!AttributeUtil::has(Response::class, $class)) {
            throw new NoResponseException('There must be at least one server response.');
        }
        $responses = AttributeUtil::all(Response::class, $class);

        $oaResponses = [];
        foreach ($responses as $response) {
            $oaResponses[$response->code] = $this->toSpec($response);
        }
        return $oaResponses;
    }

    /**
     * @param Response $response
     * @return OAResponse
     * @throws TypeErrorException
     */
    private function toSpec(Response $response): OAResponse
    {
        $oaResponse = new OAResponse([
            'description' => $response->description,
        ]);
        if ($response->schema !== null) {
            $oaResponse->content = [
                "application/json" => new MediaType([
                    'schema' => SchemeUtil::ref($response->schema)
                ])
            ];
        }
        return $oaResponse;
    }
}