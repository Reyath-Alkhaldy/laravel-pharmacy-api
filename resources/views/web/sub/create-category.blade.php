 @extends('layout')
 @section('content')
     <div class="py-3 py-md-4 checkout">
         <div class="container">
            <div class="d-flex flex-row justify-content-between">
                <h4>إنشاء صنف رئيسي جديد</h4>
                <a class="btn btn-primary fs-5" href="{{ route('web.main.index') }}"> عرض جميع الأصناف</a>
            </div>
             <x-alert/>

             <div class="row">
                

                 <div class="col-md-12">
                     <div class="shadow bg-white p-3">


                         <form action="{{ route('web.sub.store') }}" method="POST">
                             @csrf
                             <select name="main_category_id" class="form-select my-2" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach ($mainCategories as $item)
                                <option class="text-end" value="{{$item->id}}">{{$item->name_en}} </option> 
                                @endforeach
                              </select>
                             <div class="row">
                                 <div class="col-md-6 mb-3">
                                     <label>الأسم العربي</label>
                                     <input type="text" name="name_ar" class="form-control"
                                         placeholder="أدخل أسم الصنف باللغة العربية" />
                                 </div>
                                 <div class="col-md-6 mb-3">
                                     <label>الأسم الأنجليزي</label>
                                     <input lang="en" type="text" name="name_en" class="form-control"
                                         placeholder="أدخل أسم الصنف باللغة الإنجليزية"" />
                                 </div>


                             </div>
                             <div class=" w-100  text-center ">
                                 <button type="submit"
                                     class="btn btn-primary w-75 align-self-center">{{ 'Save' }}</button>
                             </div>

                         </form>

                     </div>
                 </div>

             </div>
         </div>
     </div>
 @endsection
