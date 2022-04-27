<?php

namespace Codevia\Venus\Utils\Http\Request;

use Psr\Http\Message\ServerRequestInterface as Request;

class Validate
{
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
            if (!isset($request->getParsedBody()[$field])) {
                $isValid = false;
            }
        }

        return $isValid;
    }
}
