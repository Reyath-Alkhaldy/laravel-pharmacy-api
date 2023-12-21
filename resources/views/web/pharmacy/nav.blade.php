@extends('index')
@section('content')
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav justify-between">
                <li class="nav-item ">
                    <a class="nav-link {{ Request::is('pharmacies') ? 'active fw-bold' : '' }}" aria-current="page" href="{{ route('web.pharmacies.index') }}">عرض الصيدليات</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ Request::is('pharmacies/create') ? 'active fw-bold' : '' }}" href="{{ route('web.pharmacies.create') }}">أضافة صيلية جديدة</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    @yield('section')
@endsection