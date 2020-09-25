<?php

namespace Papalardo\Laform\Fields;

use Illuminate\Support\Str;

class ImageUploadField extends FieldAbstract
{
    use \Papalardo\Laform\Traits\Attributes\HasValueAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasHelpAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasPlaceholderAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasWidthSpanAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasLabelAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasNameAttribute;

    public $default = [];

    public function __construct(string $label, string $name = null)
    {
        parent::__construct();

        $this->label = $label;
        $this->name = $name ?? Str::snake($label);
    }

    public static function make(string $label, string $name = null)
    {
        return new static($label, $name);
    }
}
