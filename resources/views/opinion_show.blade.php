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
    <div class="container mt-5 pt-5">
        <h2>ご意見まとめ</h2>
        <table border="1">
            <tr>
                <th class="width-30">id</th>
                <th class="width-100">name</th>
                <th class="width-300">opinion</th>
            </tr>
            @foreach($opinions as $opinion)
            <tr>
                <td>{{ $opinion->id }}</td>
                <td>{{ $opinion->name }}</td>
                <td>{{ $opinion->opinion }}</td>
            </tr>
            @endforeach
        </table>  
    </div>
</main>

@include('layouts.footer')