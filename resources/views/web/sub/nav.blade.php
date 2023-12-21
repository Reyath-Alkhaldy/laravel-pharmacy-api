@extends('index')
@section('content')
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav justify-between">
                <li class="nav-item ">
                    <a class="nav-link {{ Request::is('categories/sub') ? 'active fw-bold' : '' }} " aria-current="page" href="{{ route('web.sub.index') }}">عرض الأصناف</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ Request::is('categories/sub/create') ? 'active fw-bold' : '' }}" href="{{ route('web.sub.create') }}">أضافة صنف جديد</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    @yield('section')
@endsection