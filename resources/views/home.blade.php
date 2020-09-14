@extends('layouts.app')

@section('content')
<div class="container pt-5 mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <a class="btn btn-primary" href="{{ url('/') }}">TOPページへ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
