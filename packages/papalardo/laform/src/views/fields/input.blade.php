@if($field->label)
    <label for="{{ $field->name }}">{{ $field->label }}</label>
@endif
<input type="text" name="{{ $field->name }}" id="{{ $field->name }}">


