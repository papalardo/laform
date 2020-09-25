<?php

namespace Papalardo\Laform\Traits\Attributes;

trait HasLabelAttribute
{
    public $label;

    public function label(string $label)
    {
        $this->label = $label;
        return $this;
    }
}
