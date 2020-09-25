<?php

namespace Papalardo\Laform\Traits\Attributes;

trait HasNameAttribute
{
    public $name;

    public function name(string $name)
    {
        $this->name = $name;
        return $this;
    }
}
