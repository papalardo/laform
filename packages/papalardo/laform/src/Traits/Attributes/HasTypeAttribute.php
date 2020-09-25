<?php

namespace Papalardo\Laform\Traits\Attributes;

trait HasTypeAttribute
{
    public $type;

    public function type(string $type)
    {
        $this->type = $type;
        return $this;
    }
}
