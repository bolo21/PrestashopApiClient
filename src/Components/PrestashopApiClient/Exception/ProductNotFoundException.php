<?php


namespace Components\PrestashopApiClient\Exception;

use Throwable;

class ProductNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
