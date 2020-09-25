<?php

namespace Papalardo\Laform\Traits\Attributes;

trait HasWidthSpanAttribute
{
    public $withSpan;

    public function withSpan(string $withSpan)
    {
        $this->withSpan = $withSpan;
        return $this;
    }
}
