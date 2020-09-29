<?php

namespace Papalardo\Laform\Fields;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class RichMultiSelectField extends FieldAbstract
{
    use \Papalardo\Laform\Traits\Attributes\HasValueAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasHelpAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasPlaceholderAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasWidthSpanAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasLabelAttribute, 
        \Papalardo\Laform\Traits\Attributes\HasOptionsAttribute,
        \Papalardo\Laform\Traits\Attributes\HasSlotsAttribute,
        \Papalardo\Laform\Traits\Attributes\HasTrackByAttribute,
        \Papalardo\Laform\Traits\Attributes\HasFlatNameAttribute,
        \Papalardo\Laform\Traits\Attributes\HasValueResolveAttribute,
        \Papalardo\Laform\Traits\Attributes\HasNameAttribute;

    public $valueAttribute;
    
    public $textAttribute;

    protected $userValueResolve;
    
    /**
     * @param $options array|Illuminate\Database\Eloquent\Collection
     */
    public function __construct(string $label, string $name = null, $options = [])
    {
        parent::__construct();

        $this->label = $label;
        $this->name = $name ?? Str::snake($label);
        $this->flatName($this->name);
        $this->options($options);
    }

    public static function make(string $label, string $name = null, $options = [])
    {
        return new static($label, $name, $options);
    }

    public function valueAttribute($valueAttribute)
    {
        $this->valueAttribute = $valueAttribute;
        return $this;
    }

    public function textAttribute($textAttribute)
    {
        $this->textAttribute = $textAttribute;
        return $this;
    }

    public function valueResolve(Closure $userValueResolve) {
        $this->userValueResolve = $userValueResolve;
    }

    public function handle() {
        $this->handleOptions();
    }

    protected function handleOptions() {
        if(is_array($this->options)) {
            $this->options = new Collection($this->options);
        }

        if($this->trackByValue) {
            $this->options = $this->options->keyBy($this->trackByValue);
        }

        if($this->trackByLabel) {
            $this->options = $this->options->mapWithKeys(function($item, $key) {
                return [$key => $item->{$this->trackByLabel}];
            });
        }
    }

    public function resolveValue($value) {
        if(is_array($value)) {
            $value = new Collection($value);
        }
        
        if($value instanceof Collection) {
            $keyed = $value->mapWithKeys(function($item, $key) {
                return [
                    $this->trackByLabel ? $item[$this->trackByLabel] : $item
                    =>
                    $this->trackByValue ? $item[$this->trackByValue] : $key 
                ];
            });

            return $keyed->all();
        }

        return $value;
    }
}
