<?php

namespace Papalardo\Laform\Traits\Attributes;

trait HasFlatNameAttribute
{
    public $flatName;

    public function flatName(string $flatName)
    {
        $this->flatName = $flatName;
        return $this;
    }

    public function initHasFlatNameAttribute()
    {
        $this->flatName = $this->name;
    }
}
