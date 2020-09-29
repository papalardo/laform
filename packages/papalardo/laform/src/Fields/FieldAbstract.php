<?php

namespace Papalardo\Laform\Fields;

use Exception;
use JsonSerializable;
use Illuminate\Support\Str;

abstract class FieldAbstract implements JsonSerializable
{
    public $component;
    
    protected $fieldOptions = [];

    public function __construct()
    {
        $this->component = $this->getComponentName();
    }

    public function getComponentName()
    {
        return (string) Str::of(get_called_class())->afterLast('\\')->kebab();
    }

    public function setProperties(array $properties = [])
    {
        foreach ($properties as $key => $property) {
            $this->$key = $property;
        }
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected function boot()
    {
        $this->initTraits();
    }

    /**
     * Boot all of the bootable traits on the model.
     *
     * @return void
     */
    protected function initTraits()
    {
        foreach (class_uses_recursive($this) as $trait)
        {
            if (method_exists($this, $method = 'init'.class_basename($trait))) {
                $this->{$method}();
            }
        }
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function handle() {
        //
    }
}
