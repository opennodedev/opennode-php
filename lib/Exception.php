<?php
namespace OpenNode;
use ApiError;

class Exception
{
    public static function formatError($http_status, $error)
    {
        $message = '';

        if (isset($error['reason']))
            $reason = $error['reason'];

        if (isset($error['error']))
            $message = $error['error'];

        if (isset($error['message']))
            $message = $error['message'];

        return $http_status . ' - ' . $message;
    }

    public static function throwException($http_status, $error)
    {
        $reason = $error['message'];

        switch ($http_status) {
            case 400:
              throw new BadRequest(self::formatError($http_status, $error));
            case 401:
              throw new Unauthorized(self::formatError($http_status, $error));
            case 404:
              throw new NotFound(self::formatError($http_status, $error));
            case 422:
              throw new UnprocessableEntity(self::formatError($http_status, $error));
            case 429:
              throw new RateLimitException(self::formatError($http_status, $error));
            case 500:
              throw new InternalServerError(self::formatError($http_status, $error));
            default: throw new APIError(self::formatError($http_status, $error));
        }
    }
}
