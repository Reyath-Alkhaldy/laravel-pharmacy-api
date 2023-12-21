@extends('web.sub.nav')
@section('section')
<nav class="navbar bg-body-tertiary">
   <div class="container-fluid justify-content-center justify-content-md-between">
       <a class="navbar-brand fw-medium fs-3 mb-1 mb-md-0"> أضافة صنف جديد</a>
   </div>
</nav>
<x-alert />

<form class="mx-0 d-inline row gx-3 gy-4 mt-3" action="{{ route('web.sub.store') }}" method="POST">
   @csrf
   <div class="col-md-6">
       <label for="inputfirstName4" class="form-label">أسم الصنف بالعربي :</label>
       <x-form.input name="name_ar" placeholder="أسم الصنف ..."  type="text"   id="inputfirstName4"/>
   </div>
   <div dir="ltr" class="col-md-6 ">
       <label for="inputlastName3" class="form-label">Category name :</label>
       <x-form.input name="name_en" placeholder="category name..."   type="text"   id="inputfirstName3"/>
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
       <button type="submit" class="btn btn-primary">حفظ</button>
   </div>
</form>
@endsection
