<?php

namespace Papalardo\Laform\FieldSlots\SelectField;

use Papalardo\Laform\FieldSlots\AbstractSlot;

class SelectFieldOptionSlot extends AbstractSlot
{
    public function getName() {
        return 'option';
    }

    public function getProps() 
    {
        return [
            'option'
        ];
    }
}
