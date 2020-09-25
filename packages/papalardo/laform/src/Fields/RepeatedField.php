<?php

namespace Papalardo\Laform\Fields;

use Illuminate\Support\Str;
use Papalardo\Laform\Builder\FieldsBuilder;

class RepeatedField extends FieldAbstract
{
    public $default = [];

    public $fields = [];

    public function __construct(string $label, string $name = null, FieldsBuilder $fields)
    {
        parent::__construct();

        $this->label = $label;
        $this->name = $name ?? Str::snake($label);
        $this->fields = $fields->getFields();
    }

    public static function make(string $label, string $name = null, FieldsBuilder $fields)
    {
        return new static($label, $name, $fields);
    }
}
