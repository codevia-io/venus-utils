<?php

namespace Codevia\Venus\Utils\Http\Request;

use Psr\Http\Message\ServerRequestInterface as Request;

class RequestAnalizer
{
    /**
     * Get pagination query params from the request
     * 
     * @param Request $request 
     * @return array Pagination params
     */
    public static function getPagination(Request $request): array
    {
        $page = (int) ($request->getQueryParams()['page'] ?? 1);
        $limit = (int) ($request->getQueryParams()['limit'] ?? 20);

        return [
            'limit' => $limit,
            'page' => $page,
        ];
    }

    /**
     * Verify if the request contains all the required parameters
     * 
     * @param Request $request The request object
     * @param array $fields The required fields
     * @return bool `true` if all the required parameters are present, `false` otherwise
     */
    public static function parsedBody(Request $request, array $fields): bool
    {
        $isValid = true;

        foreach ($fields as $field) {
            if (!array_key_exists($field, $request->getParsedBody())) {
                $isValid = false;
            }
        }

        return $isValid;
    }
}
