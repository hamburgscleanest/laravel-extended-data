<?php

namespace hamburgscleanest\LaravelExtendedData\Tests\Helpers;

use Carbon\Carbon;
use hamburgscleanest\LaravelExtendedData\Models\ExtendedData;
use hamburgscleanest\LaravelExtendedData\Models\Helpers\DateTimeHelper;
use hamburgscleanest\LaravelExtendedData\Tests\TestCase;

class DateTimeHelperTest extends TestCase
{

    /** @test */
    public function it_can_set_value_on_extended_data_from_string()
    {
        $expect = '2018-01-01';
        $ed = new ExtendedData();
        $dtHelper = new DateTimeHelper($ed);

        $dtHelper->setValue($expect);

        $this->assertEquals($expect, $ed->datetime_01->format('Y-m-d'));
    }

    /** @test */
    public function it_can_set_value_on_extended_data_from_carbon()
    {
        $expect = Carbon::now();
        $ed = new ExtendedData();
        $dtHelper = new DateTimeHelper($ed);

        $dtHelper->setValue($expect);

        $this->assertEquals($expect->toDateTimeString(), $ed->datetime_01->toDateTimeString());
    }

    /** @test */
    public function it_implements_to_string_correctly()
    {
        $expect = Carbon::now();
        $ed = new ExtendedData(['helper' => 'birthday']);
        $dtHelper = new DateTimeHelper($ed);

        $dtHelper->setValue($expect);

        $this->assertEquals($expect->toDateString(), (string)$dtHelper);
    }
}
