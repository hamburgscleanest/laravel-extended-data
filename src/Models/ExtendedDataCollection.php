<?php

namespace hamburgscleanest\LaravelExtendedData\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

    public function delete(): bool
    {

    }

    public function update($arguments): self
    {

    }

}