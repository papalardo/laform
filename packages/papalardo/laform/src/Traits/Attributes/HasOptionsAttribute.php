<?php

namespace Papalardo\Laform\Traits\Attributes;

trait HasOptionsAttribute
{
    public $options = [];

    public function options(array $options)
    {
        $this->options = $options;
        return $this;
    }
}
