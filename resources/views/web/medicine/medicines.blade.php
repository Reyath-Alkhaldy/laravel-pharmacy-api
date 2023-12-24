@extends('web.medicine.nav')
@section('section')
    <table style="width: 99%" class="text-center mx-auto table mt-5 table-striped table-bordered">
        <thead>
            <tr>
        {{-- 'name_en', 'name_ar',  'image', 'price','count', 'status', 'description' ,'sub_category_id','pharmacy_id' --}}

                <th scope="col">#</th>
                <th scope="col">الأسم</th>
                <th scope="col" dir="ltr">The Name</th>
                <th scope="col">الصورة</th>
                <th scope="col">الوصف :</th>
                <th scope="col">سعر الحبة :</th>
                <th scope="col">العدد</th>
                <th scope="col">الحالة</th>
                <th scope="col">الصنف التابع له</th>
                <th scope="col">الصيدلية التابع لها</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($medicines as $item)
                <tr>
                    <th scope="row"> {{ $item->id }} </th>
                    <td>{{ $item->name_ar }} </td>
                    <td dir="ltr">{{ $item->name_en }} </td>
                    <td >
                        @if ($item->image)
                        <img src="{{ asset('uploads/' . $item->image) }}" class="border-t-8 border-blue-600  " style="height: 100px"
                            alt="">
                    @endif
                    </td>
                    <td>{{ $item->description }} </td>
                    <td>{{ $item->price }} </td>
                    <td>{{ $item->count }} </td>
                    <td>{{ $item->status }} </td>
                    <td>{{ $item->subCategory->name_en }} </td>
                    <td>{{ $item->pharmacy->name }} </td>
                    <td>
                        <a data-bs-toggle="tooltip" data-bs-title="عرض الصيدلية" data-bs-placement="top"
                            class="btn btn-primary btn-sm" href="{{ route('web.medicines.show', $item->id) }}"><i
                                class="bi bi-eye"></i></a>

                        <a data-bs-toggle="tooltip" data-bs-title="تعديل" data-bs-placement="top"
                            class="btn btn-primary btn-sm" href="{{ route('web.medicines.edit', $item->id) }}">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button id="{{ $item->id }}" data-bs-toggle="modal" data-id="{{ $item->id }}"
                            data-bs-target="#exampleModal" data-bs-title="حذف الصيدلية" data-bs-placement="top"
                            class="btn btn-danger btn-sm delete-modal">
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
        @include('web.medicine.modal')
        @push('scripts')
            <script>
                const csrf_token = "{{ csrf_token() }}";
                let id = 1;
            </script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
            {{-- <script src="{{ asset('js/cart.js') }}"></script> --}}
            {{-- @vite(['resources/css/app.css','resources/js/app.js']) --}}
        @endpush
    @endsection
