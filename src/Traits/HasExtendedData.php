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

        if (Str::plural($name) === $name) {
            return $this->edGetAllOfType(\str_singular($name));
        }

        return $this->edGetLatestOfType($name);
    }


    /**
     * @param $name
     * @param $arguments
     * @return ExtendedData
     */
    public function __call($name, $arguments)
    {
        $helper = "";
        $savePrefix = \config('laravel-extended-data.save_prefix', DEFAULT_SAVE_PREFIX);

        if (Str::startsWith($name, $savePrefix) && \mb_strlen($name) > \mb_strlen($savePrefix)) {
            $helper = Str::camel(\explode($savePrefix, $name)[1]);
        }

        $shouldCallHelper = !empty($helper) && ExtendedData::helperExists($helper) &&
            !\array_key_exists($helper, $this->getAttributes());

        if ($shouldCallHelper) {
            $ed = new ExtendedData(['helper' => $helper]);
            $ed->helper()->setValue(...$arguments);
            $this->extended_data()->save($ed);

            return $ed;
        }

        return parent::__call($name, $arguments);
    }


}