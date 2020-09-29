@extends('layouts.common')

@section('title')
<title>利用規約：Reha Menu</title>
@endsection

@section('pageCss')
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@include('layouts.nav')

@section('content')
<main>
    <div class="container my-5 py-5">
        <div class="card col-md-6 offset-md-3">
            <div class="card-body">
                <h1 class="h2">お問い合わせ</h1>
                <div class="my-2">
                    <ul>
                        <li>お問い合わせは下記メールアドレスにてお申し込みください。</li>
                        <li>お問い合わせ内容によっては返信をする場合があります。</li>
                        <li>すべてのお問い合わせに対応できない場合があります。予めご了承ください。</li>
                    </ul>
                </div>
                <div class="my-2">
                    <h2 class="h4">RehaMenu事務局メールアドレス</h2>
                    <a href="mailto:rehamenu.official@gmail.com">rehamenu.official@gmail.com</a>
                </div>
            </div>
        </div>
        
        <a type="button" class="btn btn-secondary col-6 offset-3 w-100 my-5 text-light" href="{{ $return_url }}">元のページに戻る</a>
    </div>
</main>
@endsection

@include('layouts.footer')