<?php

namespace hamburgscleanest\LaravelExtendedData\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ExtendedDataCollection extends Collection
{
    /** @var string $_helperName */
    private $_helperName;

    /** @var Model $_modelInstance */
    private $_modelInstance;

    /**
     * ExtendedDataCollection constructor.
     * @param array $items
     * @param Model $model
     * @param string $helperName
     */
    public function __construct($items = [], Model $model, string $helperName)
    {
        parent::__construct($items);
        $this->_modelInstance = $model;
        $this->_helperName = $helperName;
    }

    /**
     * @return ExtendedDataCollection
     */
    public function save(): self
    {
        $arguments = \func_get_args();

        if (!empty($arguments)) {
            return $this->update($arguments);
        }

        $this->items = $this->_modelInstance
            ->extended_data()
            ->saveMany(collect($this->items)
                ->map(function ($item) {
                    $ed = new ExtendedData(['helper' => $this->_helperName]);
                    $ed->helper()->setValue($item);

                    return $ed;
                })
            );

        return $this;
    }

    public function delete(): self
    {
        $arguments = \func_get_args();
        /** @var Collection $items */
        $items = collect($this->items);

        if (!empty($arguments)) {
            $items = $items->where(...$arguments);
        }


        DB::table('extended_datas')->whereIn('id', $items->pluck('id')->all())->delete();

        return $this;
    }

    public function update($arguments): self
    {

    }

}