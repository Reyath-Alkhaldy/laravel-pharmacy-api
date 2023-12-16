@props([
'name'=>'','type'=> 'text' ,'value' => '','id','label'
])
<div class="form-group">
    <label for="{{$id}}">{{$label}} </label>
    <textarea type="{{ $type   }}" name="{{ $name }}" id="{{ $id }}"
    @class([
        'form-control',
        'font-bold',
        'is-invalid' => $errors->has($name),
    ])
     {{ $attributes }} >
        {{ old($name, $value)??'' }}
    </textarea>
    @error($name)
        <div class="text-red-600">{{ $message }}</div>
    @enderror
</div>
