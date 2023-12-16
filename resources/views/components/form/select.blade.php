@props([
'name','id'=>'','main_category_id','MainCategories'
])

<select name="{{ $name }}" id="{{ $id }}" class="form-select">
    <option value=""   > select value </option>

    @foreach ($MainCategories as $category)
        <option value="{{ $category->id }}"
             @selected(old($name,$main_category_id) == $category->id)> {{ $category->id }}</option>
    @endforeach
    @error($name)
    <div  class="text-red-600">{{ $message }}</div>
    @enderror
</select>
