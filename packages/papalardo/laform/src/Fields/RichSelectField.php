<?php

namespace Papalardo\Laform\Fields;

use Illuminate\Support\Str;

class RichSelectField extends FieldAbstract
{
    use \Papalardo\Laform\Traits\Attributes\HasHelpAttribute,
        \Papalardo\Laform\Traits\Attributes\HasOptionsAttribute,
        \Papalardo\Laform\Traits\Attributes\HasLabelAttribute,
        \Papalardo\Laform\Traits\Attributes\HasNameAttribute,
        \Papalardo\Laform\Traits\Attributes\HasValueAttribute,
        \Papalardo\Laform\Traits\Attributes\HasSlotsAttribute,
        \Papalardo\Laform\Traits\Attributes\HasWidthSpanAttribute;
    
    public $default;

    public $multiple = false;

    public $valueAttribute;

    public $textAttribute;

    public function __construct(string $label, string $name = null, array $options = [])
    {
        parent::__construct();

        $this->label = $label;
        $this->name = $name ?? Str::snake($label);
        $this->options = $options;
    }

    public static function make(string $label, string $name = null, array $options = [])
    {
        return new static($label, $name, $options);
    }

    public function valueAttribute($valueAttribute)
    {
        $this->valueAttribute = $valueAttribute;
        return $this;
    }

    public function textAttribute($textAttribute)
    {
        $this->textAttribute = $textAttribute;
        return $this;
    }

    public function multiple(bool $multiple = true) {
        $this->multiple = $multiple;
        
        if($this->multiple === true) {
            $this->default = [];
        }

        return $this;
    }
}
