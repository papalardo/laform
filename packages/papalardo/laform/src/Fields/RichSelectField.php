<?php

namespace Papalardo\Laform\Fields;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class RichSelectField extends FieldAbstract
{
    use \Papalardo\Laform\Traits\Attributes\HasHelpAttribute,
        \Papalardo\Laform\Traits\Attributes\HasOptionsAttribute,
        \Papalardo\Laform\Traits\Attributes\HasLabelAttribute,
        \Papalardo\Laform\Traits\Attributes\HasNameAttribute,
        \Papalardo\Laform\Traits\Attributes\HasValueAttribute,
        \Papalardo\Laform\Traits\Attributes\HasSlotsAttribute,
        \Papalardo\Laform\Traits\Attributes\HasTrackByAttribute,
        \Papalardo\Laform\Traits\Attributes\HasFlatNameAttribute,
        \Papalardo\Laform\Traits\Attributes\HasWidthSpanAttribute;
    
    public function __construct(string $label, string $name = null, array $options = [])
    {
        parent::__construct();

        $this->label = $label;
        $this->name = $name ?? Str::snake($label);
        $this->options($options);
        $this->flatName($this->name);
    }

    public static function make(string $label, string $name = null, array $options = [])
    {
        return new static($label, $name, $options);
    }

    public function handle()
    {
        $this->handleOptions();
    }

    public function handleOptions()
    {
        throw_if(
            is_array($this->options) && !$this->trackByValue, 
            new \Exception("When [options] is array, [trackByValue] not must be null")
        );

        if(is_array($this->options)) {
            $this->options = new Collection($this->options);
        }

        if($this->trackByValue) {
            $this->options = $this->options->keyBy($this->trackByValue);
        }

        if($this->trackByLabel) {
            $this->options = $this->options->mapWithKeys(function($item, $key) {
                return [$key => $item[$this->trackByLabel] ?? null];
            });
        }
    }
}
