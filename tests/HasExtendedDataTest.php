<?php

namespace hamburgscleanest\LaravelExtendedData\Tests;

use Carbon\Carbon;
use hamburgscleanest\LaravelExtendedData\Models\ExtendedData;
use hamburgscleanest\LaravelExtendedData\Tests\Models\TestModel;

class HasExtendedDataTest extends TestCase
{
    /**
     * @test
     */
    public function it_has_extended_data_relation(): void
    {
        $this->assertEquals(1, $this->getTestDateTime()->count());
    }

    /** @test */
    public function it_can_access_extended_data_via_alias()
    {
        $birthday = '2018-01-01';
        $ed = $this->getTestDateTime($birthday);

        $this->assertEquals($birthday, $ed->base->birthday);
    }

    /** @test */
    public function it_can_access_extended_data_via_plural_alias_for_concatination()
    {
        $birthday = '2018-01-01';
        $ed = $this->getTestDateTime($birthday);

        $birthday2 = '2018-02-01';
        $ed2 = $ed->replicate();
        $ed2->datetime_01 = $birthday2;
        $ed2->save();

        $this->assertEquals(2, $ed->base->birthdays->count());
    }

    /** @test */
    public function it_can_add_new_extended_data_via_helper_function()
    {
        $newBirthday = '2018-01-01';
        $tm = TestModel::create();
        $tm->saveBirthday($newBirthday);

        $this->assertEquals($newBirthday, $tm->birthday);
    }

    /** @test */
    public function it_serves_normal_attribute_if_no_helper_is_called()
    {
        $expect = 'test';
        $tm = new TestModel();
        $tm->test = $expect;

        $this->assertEquals($expect, $tm->test);
    }

}