@props([
    'name'=>'', 'type' => 'text', 'value' => '', 'id'=>''])
<input type="{{ $type }}" name="{{$name}}" id="{{ $id }}" value="{{ old($name, $value) }}"
    @class([
        'form-control',
        'font-bold',
        'is-invalid' => $errors->has($name),
    ]) {{ $attributes }} />
@error($name)
    <x-input-error :messages="$errors->get($name)" class="mt-2 text-red-600" />
@enderror