<?php

namespace hamburgscleanest\LaravelExtendedData\Tests;

use hamburgscleanest\LaravelExtendedData\Exceptions\HelperNotFoundException;
use hamburgscleanest\LaravelExtendedData\Models\ExtendedData;
use hamburgscleanest\LaravelExtendedData\Models\Helpers\AbstractHelper;

class ExtendedDataTest extends TestCase
{
    /** @test */
    public function it_has_helper_class(): void
    {
        $ed = $this->getTestDateTime();

        $this->assertInstanceOf(AbstractHelper::class, $ed->helper());
    }

    /** @test */
    public function it_throws_error_if_helper_not_Hafound()
    {
        $ed = new ExtendedData(['helper' => 'random']);
        $this->expectException(HelperNotFoundException::class);

        $ed->helper();
    }


}
