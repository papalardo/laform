<?php

namespace Papalardo\Laform\Traits\Attributes;

trait HasValueAttribute
{
    public $value;

    public function value(string $value)
    {
        $this->value = $value;
        return $this;
    }
}
