<?php

namespace Papalardo\Laform\FieldSlots;

abstract class AbstractSlot
{
    protected $template;

    public function __construct($template) {
        $this->template = $template;
    }

    abstract public function getName();

    abstract public function getProps();

    public function getTemplate() {
        return $this->template;
    }
}
