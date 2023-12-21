@extends('index')

@section('title', $subCategory->name_en)
@section('content')

    {{-- <nav class="navbar bg-body-tertiary ">
        <div class="container-fluid  justify-content-around  ">
            <a class="navbar-brand fw-medium fs-3 mb-1 mb-md-0">عرض {{$subCategory->name_ar}} </a>
            <a class="navbar-brand fw-medium fs-3 mb-1 mb-md-0">{{$subCategory->name_en}} </a>
        </div>
    </nav> --}}

    <table style="width: 99%" class="text-center mx-auto table mt-5 table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">الأسم</th>
                <th scope="col">The name</th>
                <th scope="col">تابع للصنف الرئيسي</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>

            @if ($subCategory)
                <tr>
                    <th scope="row"> {{ $subCategory->id }} </th>
                    <td>{{ $subCategory->name_ar }} </td>
                    <td>{{ $subCategory->name_en }} </td>
                    <td dir="ltr">{{ $subCategory->mainCategory->name_en . '   ' . $subCategory->mainCategory->name_ar }} </td>
                    <td>
                        <a data-bs-toggle="tooltip" data-bs-title="تعديل الصنف" data-bs-placement="top"
                            class="btn btn-primary btn-sm" href="{{ route('web.sub.edit', $subCategory->id) }}">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button data-bs-toggle="tooltip" data-bs-title="حذف الصنف" data-bs-placement="top"
                            class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            @else
                <tr>
                    <td colspan="4">no category defined</td>
                </tr>
            @endif
        </tbody>
    </table>

@endsection
