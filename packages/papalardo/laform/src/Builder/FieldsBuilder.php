<?php

namespace Papalardo\Laform\Builder;

use Papalardo\Laform\Fields\FieldAbstract;

class FieldsBuilder
{
    protected $fields = [];

    public function __construct($fields)
    {
        foreach ($fields as $field) {
            $this->addField($field);
        }
    }

    public static function make($fields)
    {
        return new static($fields);
    }

    public function addField(FieldAbstract $field)
    {
        array_push($this->fields, $field);

        return $this;
    }

    public function getFields()
    {
        return $this->fields;
    }
}
