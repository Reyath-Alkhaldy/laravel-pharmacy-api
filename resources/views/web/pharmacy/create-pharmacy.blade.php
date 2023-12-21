@extends('web.pharmacy.nav')
@section('title', ' أضافة صيلية جديدة')
@section('section')
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid justify-content-center justify-content-md-between">
            <a class="navbar-brand fw-medium fs-3 mb-1 mb-md-0"> أضافة صيلية جديدة</a>
        </div>
    </nav>
    <x-alert />
   
    <form class="mx-0 row gx-3 gy-4 mt-3" action="{{ route('web.pharmacies.store') }}" method="post"  enctype="multipart/form-data">
        @csrf
        @include('web.pharmacy._form',[
            'botton_label'=>"Create"
        ])
    </form>
@endsection
