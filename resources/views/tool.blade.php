@extends('layouts.app')

@section('content')
    <div class="container tool-width my-5 py-5">
        <h1>{{ Auth::user()->name }}様の自主トレ管理ページ</h1>
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $message)
                <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <h2 class="mt-4">新規作成</h2>
        <div class="card">
            <div class="card-body">
                <div class="form">
                    <form action="CreateItem" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">自主トレ名:</label>
                            <input class="form-control w-50" type="text" name="item_name" id="name">    
                        </div>
                        <div class="form-group">
                            <label for="creator">作者名:</label>
                            <input class="form-control w-50" type="text" name="creator" id="creator">
                        </div>
                        <div class="form-group">
                            <label for="caption">説明文:　※改行ごとに番号が付きます。</label>
                            <textarea class="form-control w-50 h-150px" type="text" name="caption" id="caption"></textarea>
                        </div>
                        <div class="my-3">
                            <p class="mb-1">検索ワード:　※入力後の変更はできません。</p>
                            <div class="mx-3 my-2">
                                部位<br>
                                <input type="checkbox" name="search_word[]" value="頸部">頸部
                                <input type="checkbox" name="search_word[]" value="肩関節">肩関節
                                <input type="checkbox" name="search_word[]" value="腰部">腰部
                                <input type="checkbox" name="search_word[]" value="股関節">股関節
                                <input type="checkbox" name="search_word[]" value="膝関節">膝関節
                                <input type="checkbox" name="search_word[]" value="足部">足部
                            </div>
                            <div class="mx-3 my-2">
                                病名<br>
                                <input type="checkbox" name="search_word[]" value="肩関節周囲炎">肩関節周囲炎
                                <input type="checkbox" name="search_word[]" value="腰部脊柱管狭窄症">腰部脊柱管狭窄症
                                <input type="checkbox" name="search_word[]" value="腰椎椎間板ヘルニア">腰椎椎間板ヘルニア
                                <input type="checkbox" name="search_word[]" value="変形性股関節症">変形性股関節症
                                <input type="checkbox" name="search_word[]" value="変形性膝関節症">変形性膝関節症
                            </div>
                            <div class="mx-3 my-2">
                                介護部門<br>
                                <input type="checkbox" name="search_word[]" value="立位での体操">立位での体操
                                <input type="checkbox" name="search_word[]" value="座位での体操">座位での体操
                                <input type="checkbox" name="search_word[]" value="ベッドでの体操">ベッドでの体操
                                <input type="checkbox" name="search_word[]" value="セラバンド体操">セラバンド体操
                                <input type="checkbox" name="search_word[]" value="棒体操">棒体操
                            </div>
                            <div class="mx-3 my-2">
                                フリーワード欄　※複数記載する場合は「、」で区切ってください。<br>
                                <input class="form-control w-50" type="text" name="search_word[]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="template">テンプレート設定:　※入力後の変更はできません。</label>
                            <input class="form-control w-50" type="text" name="template_name" id="template">
                            <label for="template_status">テンプレートの公開設定</label>
                            <select class="form-control w-100px" name="template_status" id="template_status">
                                <option value="0">公開</option>
                                <option value="1">非公開</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">自主トレ公開設定:</label>
                            <select class="form-control w-100px" name="status" id="status">
                                <option value="0">公開</option>
                                <option value="1">非公開</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file">画像:</label>
                            <input class="form-control-file" type="file" name="file" id="file">
                        </div>
                        <p><input class="btn btn-primary"type="submit" value="自主トレ作成"></p>
                        <input type="hidden" name="sqltype" value="new_product">
                    </form>
                </div>
            </div>
        </div>
        <div class="contents mt-4">
            <h2>自主トレ情報の変更</h2>
            <table class="table table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th>自主トレ画像</th>
                        <th>基本情報</th>
                        <th>検索ワード</th>
                        <th>テンプレート</th>
                        <th>操作</th>
                    </tr>
                </thead>
                @foreach($items as $item)
                    @if($item->status===1)
                    <tr class="private small">
                    @elseif($item->status===0)
                    <tr class="small">
                    @endif
                        <td class="img_table">
                            <form id="item{{ $item->id }}" action="changeItem" method="post" enctype="multipart/form-data">@csrf</form>
                            <img class="img-thumbnail" src="{{ asset('storage/img/'.$item -> img) }}">
                            <input form="item{{ $item->id }}" type="hidden" name="img" value="{{ $item->img }}">
                        </td>
                        <td>
                            <p>自主トレ名<br>
                                <input form="item{{ $item->id }}" type="text" name="item_name" value="{{ $item->item_name }}">
                            </p>
                            <p>作者名<br>
                                <input form="item{{ $item->id }}" type="text" name="creator" value="{{ $item->creator }}">
                            </p>
                            <p>説明文<br>
                                <textarea type="text" form="item{{ $item->id }}" name="caption">{{ $item->caption }}</textarea>
                            </p>
                            <p>ステータス<br>
                                <select form="item{{ $item->id }}" name="status">
                                    @if($item->status===0)
                                        <option value='0'>現在：公開</option>
                                        <option value='1'>非公開に変更</option>
                                    @elseif($item->status===1)
                                        <option value="1">現在：非公開</option>
                                        <option value="0">公開に変更</option>
                                    @endif
                                </select>
                            </p>
                        </td>
                        <td class="search_word">{{ $item->search_word }}</td>
                        <td class="template_name">{{ $item->template_name }}</td>
                        <td>
                            <input form="item{{ $item->id }}" type="submit" value="内容変更" class="btn btn-secondary mb-3">
                            <input form="item{{ $item->id }}" type="hidden" name="sqltype" value="detail_change">
                            <input form="item{{ $item->id }}" type="hidden" name="id" value="{{ $item->id }}">
                            
                            <form id="delete{{ $item->id }}" action="toolDelete" method="post" enctype="multipart/form-data">@csrf</form>
                            <input form="delete{{ $item->id }}" type="submit" value="削除" class="btn btn-danger delete">
                            <input form="delete{{ $item->id }}" type="hidden" name="item_id" value="{{ $item->id }}">
                            <input form="delete{{ $item->id }}" type="hidden" name="deletefiles" value="{{ $item->img }}">
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection