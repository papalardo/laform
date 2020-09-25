<?php

namespace Papalardo\Laform\FieldSlots\RichSelectFieldSlots;

use Papalardo\Laform\FieldSlots\AbstractSlot;

class RichSelectFieldNoResultsSlot extends AbstractSlot
{
    public function getName() {
        return 'noResults';
    }

    public function getProps() 
    {
        return [
            'keyword'
        ];
    }
}
