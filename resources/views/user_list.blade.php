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
        <h2>ユーザー一覧</h2>
        <table border="1">
            <tr>
                <th class="width-30">id</th>
                <th class="width-100">name</th>
                <th class="width-300">email</th>
                <th class="width-100">登録日</th>
                <th class="width-100">更新日</th>
            </tr>
            @foreach($userList as $val)
            <tr>
                <td>{{ $val->id }}</td>
                <td>{{ $val->name }}</td>
                <td>{{ $val->email }}</td>
                <td>{{ $val->created_at }}</td>
                <td>{{ $val->updated_at }}</td>
            </tr>
            @endforeach
        </table>  
    </div>
</main>
<script>
    alert('テスト');
</script>
@include('layouts.footer')