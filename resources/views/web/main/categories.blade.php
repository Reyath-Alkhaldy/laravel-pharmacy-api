@extends('layout')
@section('content')
    <div class="py-3 py-md-4 checkout">
        <div class="container">
            <div class="d-flex flex-row justify-content-between">
                <h4 class="fs-4"   >عرض جميع الأصناف الرئيسية</h4>
            <div class="d-flex-inline justify-content-around">

                <a class="btn btn-primary fs-5" href="{{ route('web.main.create') }}"> إنشاء صنف جديد</a>
                
                <a class="btn btn-primary fs-5" href="{{ route('web.sub.create') }}"> إنشاء صنف فرعي جديد</a>
            </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="shadow bg-white p-3">
                        <form action="" method="POST">
                            <div class="row border border-2 m-2 p-1"> 
                                <ul class="list-group list-group-horizontal d-flex fs-5 fw-bold flex-row justify-content-evenly">
                                    <li class="list-group-item border-0">أسم الصنف بالعربي</li>
                                    <li class="list-group-item border-0" >أسم الصنف بالإنجليزي </li>
                                </ul>
                            @forelse ($mainCategories as $category)
                            <div class="table-group-divider"></div>
                                <ul class="list-group list-group-horizontal d-flex fs-5 flex-row justify-content-evenly">
                                    <li class="list-group-item border-0" ><a class="text-decoration-none" href="{{ route('web.main.show', ['main'=>$category->id]) }}">{{$category->name_ar}}</a></li>
                                    <li class="list-group-item border-0" ><a class="text-decoration-none" href="{{ route('web.main.show', ['main'=>$category->id]) }}">{{$category->name_en}}</a> </li>
                                </ul>
                                <div class="table-group-divider"></div>
                                
                                @empty
                            </div>
                                <tr>
                                    <td colspan="9">no category defined</td>
                                </tr>
                                 @endforelse


                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
