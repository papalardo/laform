<?php

namespace Papalardo\Laform\Forms;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Papalardo\Laform\Fields\FieldAbstract;
use Papalardo\Laform\Fields\RepeatedField;

class FormBuilder
{
    public $fields = [];

    public $form_data = [];

    public $model;

    public function __construct(Model $model = null)
    {
        $this->model = $model;
    }

    public static function init($model = null) {
        return new static($model);
    }

    public function addField(FieldAbstract $field, array $options = [])
    {
        $field->setProperties($options);
        $field->handle();

        array_push($this->fields, $field);
        
        return $this;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function fill($payload) 
    {
        throw_if(!count($this->fields), new \Exception('Fields must be defined before fill data'));

        $this->form_data = (new \Papalardo\Laform\Resolvers\FormDataResolver($this->fields, $payload))->getFormData();
    }

    public function getForm()
    {
        $this->fill($this->model);
        return $this;
    }
}
