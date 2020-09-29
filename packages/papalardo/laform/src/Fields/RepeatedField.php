<?php

namespace Papalardo\Laform\Fields;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Papalardo\Laform\Builder\FieldsBuilder;
use Papalardo\Laform\Resolvers\FormDataResolverPipeline;

class RepeatedField extends FieldAbstract
{
    use \Papalardo\Laform\Traits\Attributes\HasFlatNameAttribute;

    public $default = [];

    public $fields = [];

    public function __construct(string $label, string $name = null, FieldsBuilder $fields)
    {
        parent::__construct();

        $this->label = $label;
        $this->name = $name ?? Str::snake($label);
        $this->fields = $fields->getFields();
        $this->flatName($this->name);
        $this->setFlatNameChildrenFields();
    }

    public static function make(string $label, string $name = null, FieldsBuilder $fields)
    {
        return new static($label, $name, $fields);
    }

    public function setFlatNameChildrenFields()
    {
        foreach($this->fields as $field) {
            $field->flatName($this->flatName.".".$field->name);
            if($field instanceof RepeatedField) {
                $field->setFlatNameChildrenFields();
            }
        }
    }

    public function handle() {
        foreach($this->fields as $field) {
            $field->handle();
        }
    }
}
