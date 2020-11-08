@extends('layouts.common')

@section('title')
<title>ご意見箱：Reha Menu</title>
@endsection

@section('pageCss')
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@include('layouts.nav')

@section('content')
<main>
    <div class="container pt-5 my-5">
        <div class="card col-md-8 m-auto">
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $message)
                        <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
                @elseif(session('message'))
                <div class="alert alert-success" role="alert">
                    <p>{{ session('message') }}</p>
                </div>
                @endif
                <h3 class="text-center">お問い合わせ＆ご意見箱</h3>
                <form action="giveOpinion" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">お名前(必須)</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">ご意見入力(必須)</label>
                        <textarea class="form-control" name="opinion" cols="30" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">送信</button>
                    <input type="hidden" name="return_url" value="$return_url">
                </form>
                <a type="button" class="btn btn-secondary w-100 mt-2 text-light" href="{{ url( '/' ) }}">TOPページに戻る</a>
            </div>
        </div>
    </div>
</main>
@endsection

@include('layouts.footer')