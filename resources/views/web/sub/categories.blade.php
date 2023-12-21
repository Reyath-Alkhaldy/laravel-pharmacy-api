@extends('web.sub.nav')
@section('section')
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
            @forelse ($mainCategories as $item)
                <tr>
                    <th scope="row"> {{ $item->id }} </th>
                    <td>{{ $item->name_ar }} </td>
                    <td>{{ $item->name_en }} </td>
                    <td dir="ltr">{{ $item->mainCategory->name_en . '   ' . $item->mainCategory->name_ar }} </td>

                    <td>
                        <a data-bs-toggle="tooltip" data-bs-title="عرض الصنف" data-bs-placement="top"
                            class="btn btn-primary btn-sm" href="{{ route('web.sub.show', $item->id) }}"><i
                                class="bi bi-eye"></i></a>

                        <a data-bs-toggle="tooltip" data-bs-title="Edit user" data-bs-placement="top"
                            class="btn btn-primary btn-sm" href="{{ route('web.sub.edit', $item->id) }}">
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
    @endsection
