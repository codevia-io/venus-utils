<?php

namespace Codevia\Venus\Utils\Http;

use Psr\Http\Message\ResponseInterface;

class Response
{
    public static function json(ResponseInterface $response, mixed $content): ResponseInterface
    {
        $payload = json_encode($content);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
