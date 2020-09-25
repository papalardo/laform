<?php

namespace Papalardo\Laform\Forms;

use Illuminate\Database\Eloquent\Model;
use Papalardo\Laform\Fields\FieldAbstract;

class FormBuilder
{
    public $fields = [];

    public function __construct(Model $model = null)
    {
    }

    public function add(string $name, string $field, array $options = [])
    {
        $fieldInstance = new $field;
        $fieldInstance->name = $name;
        $fieldInstance->setProperties($options);

        array_push($this->fields, $fieldInstance);

        return $this;
    }

    public function addField(FieldAbstract $field, array $options = [])
    {
        $field->setProperties($options);

        array_push($this->fields, $field);
        
        return $this;
    }

    public function getFields()
    {
        return $this->fields;
    }
}
