<?php

namespace Papalardo\Laform\Traits\Attributes;

trait HasHelpAttribute
{
    public $help;

    public function help(string $help)
    {
        $this->help = $help;
        return $this;
    }
}
