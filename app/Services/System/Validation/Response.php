<?php

namespace App\Services\System\Validation;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * Class Response
 */
class Response
{
    public static function httpCode(mixed $code): int
    {
        $code = (int) $code;
        if (
            $code >= HttpResponse::HTTP_CONTINUE and $code <= HttpResponse::HTTP_EARLY_HINTS or
            $code >= HttpResponse::HTTP_OK and $code <= HttpResponse::HTTP_IM_USED or
            $code >= HttpResponse::HTTP_MULTIPLE_CHOICES and $code <= HttpResponse::HTTP_PERMANENTLY_REDIRECT or
            $code >= HttpResponse::HTTP_BAD_REQUEST and $code <= HttpResponse::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS or
            $code >= HttpResponse::HTTP_INTERNAL_SERVER_ERROR and $code <= HttpResponse::HTTP_NETWORK_AUTHENTICATION_REQUIRED
        ) {
            return $code;
        }

        return HttpResponse::HTTP_BAD_REQUEST;
    }
}
