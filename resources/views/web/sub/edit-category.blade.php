@extends('index')

@section('title', $mainCategory->name_en)
@section('content')

    <nav class="navbar bg-body-tertiary ">
        <div class="container-fluid  justify-content-around  ">
            <a class="navbar-brand fw-medium fs-3 mb-1 mb-md-0">{{ $mainCategory->name_ar }} </a>
            <a class="navbar-brand fw-medium fs-3 mb-1 mb-md-0">{{ $mainCategory->name_en }} </a>
        </div>
    </nav>
<h4 class="text-center">تعديل الصنف</h4>
    <form class="mx-0 d-inline row gx-3 gy-4 mt-3" action="{{ route('web.sub.update', $mainCategory->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="col-md-6">
            <label for="inputfirstName4" class="form-label">أسم الصنف بالعربي :</label>
            <x-form.input name="name_ar"   type="text" value="{{ $mainCategory->name_ar }}" />
        </div>
      
        <div dir="ltr" class="col-md-6 ">
            <label for="inputlastName4" class="form-label">Category name :</label> 
            <x-form.input name="name_en"   type="text" value="{{ $mainCategory->name_en }}" />
        </div>
        <div>
            <div dir="ltr" class="col-md-6">
                <label for="inputCountry" class="form-label">Country:</label>
                <select id="inputCountry" name="main_category_id" class="form-select">
                    <option selected hidden disabled>Choose here ...   أختر هنا</option>
                    @foreach ($mainCategories as $item)
                    <option value="{{$item->id}}">{{$item->id."     ".$item->name_en."     ".$item->name_ar}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">تعديل</button>
        </div>
    </form>

@endsection
