@extends('layouts.app')

@section('content')
    <div class="container pt-5 mt-5">
    <div class="card col-md-10 m-auto">
        <div class="card-body">
            <img class="img-fluid rounded" src="./img/reha-menu-manual.png" alt="">
            <a type="button" class="btn btn-secondary w-100 mt-2 text-light" href="{{ url('/index') }}">戻る</a>
        </div>
    </div>
    </div>
@endsection