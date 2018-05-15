<?php

namespace hamburgscleanest\LaravelExtendedData\Exceptions;
use Throwable;

/**
 * Class HelperNotFoundException
 * @package hamburgscleanest\LaravelExtendedData\Exceptions
 */
class HelperNotFoundException extends \RuntimeException
{

    public function __construct()
    {
        parent::__construct('Please provide a valid Helper.');
    }

}