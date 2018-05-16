<?php

namespace hamburgscleanest\LaravelExtendedData\Tests;

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

    /** @test */
    public function it_calls_class_function_if_helper_isnt_found()
    {
        $tm = TestModel::create();

        $this->expectException(\BadMethodCallException::class);

        $tm->saveTest();

    }

    /** @test */
    public function it_can_save_extended_data_with_given_helper()
    {
        $tm = TestModel::create();
        $expect = '2018-01-01';

        $ed = $tm->saveExtendedData('birthday', [$expect]);

        $this->assertEquals($expect, (string)$ed->helper());
    }

    /** @test */
    public function it_can_save_multiple_extended_datas_at_once()
    {
     $tm = TestModel::create();
     $date1 = '2018-01-01';
     $date2 = '2018-02-01';

     $tm->saveBirthdays($date1, $date2);

     $this->assertEquals(2, $tm->birthdays->count());
    }

}