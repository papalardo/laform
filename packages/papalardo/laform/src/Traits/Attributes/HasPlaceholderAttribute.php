<?php

namespace Papalardo\Laform\Traits\Attributes;

trait HasPlaceholderAttribute
{
    public $placeholder;

    public function placeholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }
}
