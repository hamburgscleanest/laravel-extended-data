<?php

namespace hamburgscleanest\LaravelExtendedData\Models;


use Carbon\Carbon;
use hamburgscleanest\LaravelExtendedData\Exceptions\HelperNotFoundException;
use hamburgscleanest\LaravelExtendedData\Models\Helpers\AbstractHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

/**
 * Class ExtendedData
 * @package hamburgscleanest\LaravelExtendedData\Models
 *
 * @property int id
 * @property string helper
 * @property Carbon datetime_01
 * @property Model base
 */
class ExtendedData extends Model
{
    protected $table = 'extended_datas';

    protected $guarded = [];

    protected $with = ['base'];

    protected $dates = ['datetime_01'];

    protected $casts = ['data_extendable_id' => 'int'];

    /**
     * @param string $helper
     * @return bool
     */
    public static function helperExists(string $helper): bool
    {
        return \array_key_exists(Str::camel(Str::singular($helper)), \config('laravel-extended-data.helpers', []));
    }

    /** @var AbstractHelper */
    private $_helperInstance;

    /**
     * @return MorphTo
     */
    public function base(): MorphTo
    {
        return $this->morphTo('data_extendable');
    }


    /**
     * The helper instance for the given helper.
     * @return AbstractHelper
     */
    public function helper(): AbstractHelper
    {
        $helperClassName = \config('laravel-extended-data.helpers.' . $this->helper);

        if (empty($helperClassName)) {
            throw new HelperNotFoundException();
        }

        if (!$this->_helperInstance) {
            $this->_helperInstance = new $helperClassName($this);
        }

        return $this->_helperInstance;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->helper();
    }
}