@props([
    'name','options'=>[] ,'checked'=>false
])
<label for="">الحالة :</label>
@foreach ($options as $value => $text )
<div class="  form-check-inline">
    <input type="radio" name="{{$name}}" value="{{ $value }}" @checked(old($name,$checked) == $value)
     {{$attributes->class([ 'form-check-input','is-invalid'=>$errors->has($name)])}} 
        id="form-check-input" />
    <label for="form-check-input" class="form-check-label">{{$text}}</label>
</div>
    
@endforeach
<x-input-error :messages="$errors->get($name)" class="mt-2 text-red-600" />
