<?php

namespace Papalardo\Laform\Fields;

use Illuminate\Support\Str;

class InputField extends FieldAbstract
{
    use \Papalardo\Laform\Traits\Attributes\HasTypeAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasValueAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasHelpAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasPlaceholderAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasWidthSpanAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasLabelAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasFlatNameAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasValueResolveAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasNameAttribute;

    public $default = '';

    public $prependAddon;

    public $appendAddon;

    public function __construct(string $label, string $name = null)
    {
        parent::__construct();

        $this->label = $label;
        $this->name = $name ?? Str::snake($label);
        $this->flatName($this->name);
    }

    public static function make(string $label, string $name = null)
    {
        return new static($label, $name);
    }

    ### Options ###
    
    public function appendAddon($appendAddon)
    {
        $this->appendAddon = $appendAddon;
        return $this;
    }

    public function prependAddon($prependAddon)
    {
        $this->prependAddon = $prependAddon;
        return $this;
    }

    public function resolveValue($value) {
        return 'Value Resolved => '. $value;
    }
}
