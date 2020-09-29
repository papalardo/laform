<?php

namespace Papalardo\Laform\Traits\Attributes;

trait HasTrackByAttribute
{
    public $trackByValue;

    public $trackByLabel;

    public function trackBy(string $trackByLabel, string $trackByValue)
    {
        $this->trackByLabel($trackByLabel);

        $this->trackByValue($trackByValue);

        return $this;
    }

    public function trackByValue(string $trackByValue) 
    {
        $this->trackByValue = $trackByValue;

        return $this;
    }

    public function trackByLabel(string $trackByLabel) 
    {
        $this->trackByLabel = $trackByLabel;

        return $this;
    }
}
