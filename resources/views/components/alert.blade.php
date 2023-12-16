@if(session()->has('message'))
<div class="alert alert-success">{{session('message')}}</div>
<div class="alert alert-primary" >
    {{session('message')}}
</div>
@endif