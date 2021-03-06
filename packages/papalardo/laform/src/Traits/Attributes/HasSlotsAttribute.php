<?php

namespace Papalardo\Laform\Traits\Attributes;

use InvalidArgumentException;
use Papalardo\Laform\FieldSlots\AbstractSlot;

trait HasSlotsAttribute
{
    public $slots = [];

    public function addSlot(AbstractSlot $slot)
    {
        $this->slots[$slot->getName()] = [
            'props' => $slot->getProps(),
            'template' => $slot->getTemplate()
        ];
        
        return $this;
    }

    public function setSlot(AbstractSlot $slot) 
    {
        return $this->addSlot($slot);
    }

    public function addSlots(array $slots) 
    {
        foreach($slots as $slot) {
            $this->addSlot($slot);
        }

        return $this;
    }

    public function setSlots(array $slots) 
    {
        $this->slots = [];

        return $this->addSlots($slots);
    }

    /**
     * @param string|\Papalardo\Laform\FieldSlots\AbstractSlot $slot 
     */
    public function removeSlot($slot)
    {
        if($slot instanceof \Papalardo\Laform\FieldSlots\AbstractSlot) {
            $slot = $slot->getName();
        }

        if(is_string($slot)) {
            unset($this->slots[$slot]);
        } else {
            throw new InvalidArgumentException("Slot must be string or \Papalardo\Laform\FieldSlots\AbstractSlot instance");
        }
        
        return $this;
    }
}
