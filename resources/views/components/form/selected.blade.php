@props([
'name','id'=>'','options','selected'=>''
])

<select name="{{ $name }}" id="{{ $id }}"
@class([
    'form-control',
    'font-bold',
    'is-invalid' => $errors->has($name),
]) {{ $attributes }}
 >
    <option value=""   > select value </option>

    @foreach ($options as $value => $text)
        <option value="{{ $value }}"
             @selected(old($name,$value) == $selected)> {{ $text }}</option>
    @endforeach
</select>
