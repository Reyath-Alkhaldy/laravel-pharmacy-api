@extends('web.pharmacy.nav')
@section('section')
    <table style="width: 99%" class="text-center mx-auto table mt-5 table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">الأسم</th>
                <th scope="col">رقم الهاتف :</th>
                <th scope="col">العنوان :</th>
                <th scope="col">الحالة :</th>
                <th scope="col">عدد الأيام المسموح :</th>
                <th scope="col">Action</th>
                <th scope="col">الصورة</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pharmacies as $item)
                <tr>
                    <th scope="row"> {{ $item->id }} </th>
                    <td>{{ $item->name }} </td>
                    <td>{{ $item->phone_number }} </td>
                    <td>{{ $item->address }} </td>
                    <td>{{ $item->status }} </td>
                    <td>{{ $item->number_of_view_days }} </td>
                    <td>
                        <a data-bs-toggle="tooltip" data-bs-title="عرض الصيدلية" data-bs-placement="top"
                            class="btn btn-primary btn-sm" href="{{ route('web.pharmacies.show', $item->id) }}"><i
                                class="bi bi-eye"></i></a>

                        <a data-bs-toggle="tooltip" data-bs-title="تعديل" data-bs-placement="top"
                            class="btn btn-primary btn-sm" href="{{ route('web.pharmacies.edit', $item->id) }}">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button id="{{ $item->id }}" data-bs-toggle="modal" data-id="{{ $item->id }}"
                            data-bs-target="#exampleModal" data-bs-title="حذف الصيدلية" data-bs-placement="top"
                            class="btn btn-danger btn-sm delete-modal">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                    
                    <td >
                        @if ($item->logo_image)
                        <img src="{{ asset('uploads/' . $item->logo_image) }}" class="border-t-8 border-blue-600  " style="height: 100px"
                            alt="">
                    @endif
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="4">no category defined</td>
                </tr>
            @endforelse
        </tbody>
        @include('web.pharmacy.modal')
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
