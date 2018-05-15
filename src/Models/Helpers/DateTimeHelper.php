<?php

namespace hamburgscleanest\LaravelExtendedData\Models\Helpers;


use Carbon\Carbon;
use hamburgscleanest\LaravelExtendedData\Models\ExtendedData;

class DateTimeHelper extends AbstractHelper
{
    /**
     * @return string
     */
    private function _getDateFormat(): string
    {
        return \config('laravel-extended-data.formats.birthday', 'Y-m-d');
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->_extendedData->datetime_01->format($this->_getDateFormat());
    }

    /**
     * @param mixed $value
     * @return ExtendedData
     */
    public function setValue($value): ExtendedData
    {
        if ($value instanceof Carbon || $value instanceof \DateTime) {
            $this->_extendedData->datetime_01 = $value->format($this->_getDateFormat());
        }

        $this->_extendedData->datetime_01 = $value;

        return $this->_extendedData;
    }
}