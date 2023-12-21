@extends('index')

@section('title', $mainCategory->name_en)
@section('content')

    <nav class="navbar bg-body-tertiary ">
        <div class="container-fluid  justify-content-around  ">
            <a class="navbar-brand fw-medium fs-3 mb-1 mb-md-0">عرض {{$mainCategory->name_ar}} </a>
            <a class="navbar-brand fw-medium fs-3 mb-1 mb-md-0">{{$mainCategory->name_en}} </a>
        </div>
    </nav>

 
<table style="width: 99%" class="text-center mx-auto table mt-5 table-striped table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">الأسم</th>
            <th scope="col">The name</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($mainCategory->subCategories as $item)
            
        <tr>
            <th scope="row"> {{$item->id}} </th>
            <td>{{$item->name_ar}} </td>
            <td>{{$item->name_en}}  </td>
            <td>
                <a data-bs-toggle="tooltip" data-bs-title="View details" data-bs-placement="top"
                    class="btn btn-primary btn-sm" href="{{ route('web.sub.show', $item->id) }}"><i class="bi bi-eye"></i></a>

                <a data-bs-toggle="tooltip" data-bs-title="Edit user" data-bs-placement="top"
                    class="btn btn-primary btn-sm" href="{{ route('web.sub.show', $item->id) }}">
                    <i class="bi bi-pencil"></i>
                </a>
                <button data-bs-toggle="tooltip" data-bs-title="Delete user" data-bs-placement="top"
                    class="btn btn-danger btn-sm">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4">no category defined</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection
