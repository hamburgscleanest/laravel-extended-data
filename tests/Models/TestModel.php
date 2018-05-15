<?php

namespace hamburgscleanest\LaravelExtendedData\Tests\Models;

use hamburgscleanest\LaravelExtendedData\Traits\HasExtendedData;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    use HasExtendedData;

    protected $guarded = [];

}