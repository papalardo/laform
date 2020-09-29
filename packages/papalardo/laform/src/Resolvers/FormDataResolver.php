<?php

namespace Papalardo\Laform\Resolvers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Papalardo\Laform\Fields\RepeatedField;
use Illuminate\Database\Eloquent\Relations\Relation;

class FormDataResolver
{
    protected $fields;
    
    protected $model;

    protected $form_data = [];

    public function __construct(array $fields, Model $model)
    {
        $this->fields = $fields;
        $this->model = $model;

        $this->run();
    }

    protected function run()
    {
        $this->touchRelationShipAttributes($this->fields, $this->model);

        $this->handleFieldsValue($this->fields);
    }

    protected function handleFieldsValue($fields, $deepName = null) {
        foreach($fields as $field) {
            $fieldName = $deepName ? ($deepName.".".$field->name) : $field->name;
            if($field instanceof \Papalardo\Laform\Fields\RepeatedField) {
                foreach(Arr::get($this->model, $fieldName, []) as $key => $values) {
                    $this->handleFieldsValue($field->fields, $fieldName.".".$key);
                }
                continue;
            }
            Arr::set($this->form_data, $fieldName, $this->getValueByField($field, $fieldName));
        }
    }

    public function touchRelationShipAttributes($fields, $model)
    {
        foreach($fields as $field) {
            if($field instanceof \Papalardo\Laform\Fields\RepeatedField && property_exists($model, $field->name)) {
                $this->touchRelationShipAttributes($field->fields, $model->{$field->name});
            }

            if($this->isRelationship(Str::camel($field->name), $model)) {
                $model->{Str::camel($field->name)};
            }
        }
    }

    public function getValueByField($field, $deepName = null) {
        $value = Arr::get($this->model->toArray(), $deepName ?? $field->flatName);

        if(method_exists($field, 'resolveValue')) {
            $value = $field->resolveValue($value);
        }

        if(property_exists($field, 'user_value_resolve') && $fn = $field->user_value_resolve) {
            return $fn($value);
        }

        $formMethod = Str::camel('form_'.$field->flatName.'_attribute');

        if(method_exists($this->model, $formMethod)) {
            return $this->model->$formMethod($value);
        }

        return $value;
    }

    protected function getFlattenFields(array $fields = []) : array
    {
        $acumulatorFields = [];
        foreach($fields as $field) {
            if($field instanceof \Papalardo\Laform\Fields\RepeatedField) {
                $acumulatorFields = array_merge($acumulatorFields, $this->getFlattenFields($field->fields));
                continue;
            }
            $acumulatorFields[] = $field;
        }
        return $acumulatorFields;
    }

    protected function isRelationship($attribute, $model)
    {
        return method_exists($model, Str::camel($attribute)) && $model->{Str::camel($attribute)}() instanceof \Illuminate\Database\Eloquent\Relations\Relation;
    }

    /**
     * Get all of the attribute mutator methods.
     *
     * @param  mixed  $class
     * @return array
     */
    protected static function getAcessorMethods($class)
    {
        preg_match_all('/(?<=^|;)form([^;]+?)GetAttribute(;|$)/', implode(';', get_class_methods($class)), $matches);

        return $matches[1];
    }

    public function getFormData()
    {
        return $this->form_data;
    }
}
