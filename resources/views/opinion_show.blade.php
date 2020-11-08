@extends('layouts.common')

@section('title')
<title>ご意見一覧：Reha Menu</title>
@endsection

@section('pageCss')
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
<style>
    .width-30{
        width: 30px;
    }

    .width-100{
        width: 100px;
    }

    .width-300{
        width: 300px;
    }
</style>
@endsection

@include('layouts.nav')

@section('content')
<main>
    <div class="container my-5 py-5">
        <h2>お問い合わせ＆ご意見まとめ</h2>
        <table border="1">
            <tr>
                <th class="width-30">id</th>
                <th class="width-100">name</th>
                <th class="width-100">email</th>
                <th class="width-300">opinion</th>
                <th class="width-100">created_at</th>
            </tr>
            @foreach($opinions as $opinion)
            <tr>
                <td>{{ $opinion->id }}</td>
                <td>{{ $opinion->name }}</td>
                <td>{{ $opinion->email}}</td>
                <td>{{ $opinion->opinion }}</td>
                <td>{{ $opinion->created_at }}</td>
            </tr>
            @endforeach
        </table>  
    </div>
</main>

@include('layouts.footer')