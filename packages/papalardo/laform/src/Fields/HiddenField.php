<?php

namespace Papalardo\Laform\Fields;

use Illuminate\Support\Str;

class HiddenField extends FieldAbstract
{
    use \Papalardo\Laform\Traits\Attributes\HasValueAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasNameAttribute;

    public $default = '';

    public function __construct(string $name, string $value)
    {
        parent::__construct();

        $this->name = $name;
        $this->value = $value;
    }

    public static function make(string $name, string $value)
    {
        return new static($name, $value);
    }
}
