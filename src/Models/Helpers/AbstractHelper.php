<?php

namespace hamburgscleanest\LaravelExtendedData\Models\Helpers;

use hamburgscleanest\LaravelExtendedData\Models\ExtendedData;

abstract class AbstractHelper
{
    /** @var ExtendedData $_extendedData */
    protected $_extendedData;

    /**
     * AbstractHelper constructor.
     * @param ExtendedData $extendedData
     */
    public function __construct(ExtendedData $extendedData)
    {
        $this->_extendedData = $extendedData;
    }

    /**
     * @return string
     */
    public abstract function __toString(): string;

    /**
     * @param mixed $value
     * @return ExtendedData
     */
    public abstract function setValue($value): ExtendedData;
}