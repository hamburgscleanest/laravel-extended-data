<?php

namespace hamburgscleanest\LaravelExtendedData\Tests\Models;

use hamburgscleanest\LaravelExtendedData\Models\ExtendedData;
use hamburgscleanest\LaravelExtendedData\Models\ExtendedDataCollection;
use hamburgscleanest\LaravelExtendedData\Tests\TestCase;

class ExtendedDataCollectionTest extends TestCase
{
    /** @test */
    public function it_can_save_a_collection()
    {
        $tm = TestModel::create();
        $ed1 = '2018-01-01';
        $ed2 = '2018-01-02';
        $coll = new ExtendedDataCollection([$ed1, $ed2], $tm, 'birthday');

        $coll->save();

        $this->assertEquals(2, ExtendedData::count());

        $this->assertEquals(2, $coll->count());
    }

    /** @test */
    public function it_can_delete_a_collection()
    {
        $tm = TestModel::create();
        $col = (new ExtendedDataCollection(['2018-01-01'], $tm, 'birthday'))->save();
        $col->delete();


        $this->assertEquals(0, ExtendedData::count());
    }

    /** @test */
    public function it_can_delete_a_collection_with_filters()
    {
        $tm = TestModel::create();
        $ed1 = '2018-01-01';
        $ed2 = '2018-01-02';
        $col= (new ExtendedDataCollection([$ed1, $ed2], $tm, 'birthday'))->save();

        $col->delete('id', ExtendedData::whereDate('datetime_01', $ed1)->first()->id);

        $this->assertEquals(1, ExtendedData::count());
    }
}
