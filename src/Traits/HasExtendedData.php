<?php

namespace hamburgscleanest\LaravelExtendedData\Traits;


use hamburgscleanest\LaravelExtendedData\Models\ExtendedData;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

const DEFAULT_SAVE_PREFIX = 'save';

/**
 * Trait HasExtendedData
 * @package hamburgscleanest\LaravelExtendedData\Traits
 *
 * @property ExtendedData|ExtendedData[]|Collection extended_data
 */
trait HasExtendedData
{
    /**
     * @return MorphMany|null
     */
    public function extended_data(): ?MorphMany
    {
        return $this->morphMany(ExtendedData::class, 'data_extendable');
    }


    /**
     * @param string $helperName
     * @return ExtendedData|null
     */
    public function edGetLatestOfType(string $helperName): ?ExtendedData
    {
        return $this->extended_data()->where(['helper' => $helperName])->latest()->first();
    }

    /**
     * @param string $helperName
     * @return Collection|null|ExtendedData[]
     */
    public function edGetAllOfType(string $helperName): ?Collection
    {
        return $this->extended_data()->where(['helper' => $helperName])->get();
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (!ExtendedData::helperExists($name)) {
            return parent::__get($name);
        }

        if ($this->_isPlural($name)) {
            return $this->edGetAllOfType(\str_singular($name));
        }

        return $this->edGetLatestOfType($name);
    }

    /**
     *
     * @param string $callee
     * @param string $prefix
     * @return null|string
     */
    private function _getConcatenatedHelper(string $callee, string $prefix): ?string
    {
        $helper = null;

        if (!Str::startsWith($callee, $prefix) || Str::length($prefix) < Str::length($prefix)) {
            return null;
        }

        $helper = Str::camel(\explode($prefix, $callee)[1]);

        if (!ExtendedData::helperExists($helper) || \array_key_exists($helper, $this->getAttributes())) {
            return null;
        }

        return $helper;
    }


    /**
     * @param string $helperName
     * @return bool
     */
    private function _isPlural(string $helperName): bool
    {
        return Str::plural($helperName) === $helperName;
    }

    /**
     * Save an ExtendedData record with the helper.
     * @param string $helperName
     * @param $arguments
     * @return ExtendedData
     */
    public function saveExtendedData(string $helperName, $arguments): ExtendedData
    {
        $ed = new ExtendedData(['helper' => $helperName]);
        $ed->helper()->setValue(...$arguments);
        $this->extended_data()->save($ed);

        return $ed;
    }


    /**
     * @param $name
     * @param $arguments
     * @return ExtendedData
     */
    public function __call($name, $arguments)
    {
        $savePrefix = \config('laravel-extended-data.save_prefix', DEFAULT_SAVE_PREFIX);

        if (!$helper = $this->_getConcatenatedHelper($name, $savePrefix)) {
            return parent::__call($name, $arguments);
        }


        return $this->saveExtendedData($helper, $arguments);
    }


}