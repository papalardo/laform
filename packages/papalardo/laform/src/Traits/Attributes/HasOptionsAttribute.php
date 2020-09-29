<?php

namespace Papalardo\Laform\Traits\Attributes;

use Illuminate\Support\Arr;

trait HasOptionsAttribute
{
    /**
     * @var array|\Illuminate\Database\Eloquent\Collection
     */
    public $options = [];

    public function options($options = [])
    {
        $this->options = $options;
        
        if(is_array($options)) {
            $this->options = Arr::isAssoc($options) || array_filter($options, function($item) {
                return !is_string($item);
            }) ? $options : array_combine($options, $options);
        }

        return $this;
    }
}
