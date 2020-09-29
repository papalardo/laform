<?php

namespace Papalardo\Laform\Traits\Attributes;

use Closure;

trait HasValueResolveAttribute
{
    public $user_value_resolve;

    public function valueResolve(Closure $user_value_resolve)
    {
        $this->user_value_resolve = $user_value_resolve;
        return $this;
    }
}
