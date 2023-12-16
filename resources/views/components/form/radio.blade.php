@props([
    'name','options'=>[] ,'checked'=>false
])

@foreach ($options as $value => $text )
<div class="form-check">
    <input type="radio" name="{{$name}}" value="{{ $value }}" @checked(old($name,$checked) == $value)
     {{$attributes->class([ 'form-check-input','is-invalid'=>$errors->has($name)])}} 
        id="form-check-input" />
    <label for="form-check-input" class="form-check-label">{{$text}}</label>
</div>
    
@endforeach