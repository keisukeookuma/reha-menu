@extends('layouts.common')

@section('title')
<title>トレーニング作成ページ：Reha Menu</title>
@endsection

@section('pageCss')
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@include('layouts.nav')

@section('content')
<main>
    <div class="container tool-width my-5 py-5">
        <h1>{{ Auth::user()->name }}様のトレーニング管理ページ</h1>
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $message)
                <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link text-dark font-14px active" id="nav-item-catalog-tab" data-toggle="tab" href="#nav-item-catalog" role="tab" aria-controls="nav-item-catalog" aria-selected="true">トレーニング一覧</a>
                <a class="nav-item nav-link text-dark font-14px" id="nav-make-item-tab" data-toggle="tab" href="#nav-make-item" role="tab" aria-controls="nav-make-item" aria-selected="false">トレーニング作成</a>
                <a class="nav-item nav-link text-dark font-14px" id="nav-template-catalog-tab" data-toggle="tab" href="#nav-template-catalog" role="tab" aria-controls="nav-template-catalog" aria-selected="false">テンプレート一覧</a>
                <a class="nav-item nav-link text-dark font-14px" id="nav-make-template-tab" data-toggle="tab" href="#nav-make-template" role="tab" aria-controls="nav-make-template" aria-selected="false">テンプレート作成</a>
                @if($admin === 'admin')
                <a class="nav-item nav-link text-dark" href="{{ url('opinionShow') }}">ご意見一覧へ</a>
                @endif
                <a class="nav-item nav-link text-dark" href="{{ url('index') }}">管理ページ退出</a>
            </div>
        </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-item-catalog" role="tabpanel" aria-labelledby="nav-item-catalog-tab">
            <div class="contents">
                <table class="table table-bordered text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>トレーニング画像</th>
                            <th>基本情報</th>
                            <th>検索ワード</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    @foreach($items as $item)
                        @if($item->items_status===1)
                        <tr class="private small">
                        @elseif($item->items_status===0)
                        <tr class="small">
                        @endif
                            <td class="img_table">
                                <form id="item{{ $item->id }}" action="changeItem" method="post" enctype="multipart/form-data">@csrf</form>
                                <img class="img-thumbnail" src="{{ asset('storage/img/'.$item -> img) }}">
                                <input form="item{{ $item->id }}" type="hidden" name="img" value="{{ $item->img }}">
                            </td>
                            <td>
                                <p>トレーニング名<br>
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
                                        @if($item->items_status===0)
                                            <option value='0'>現在：公開</option>
                                            <option value='1'>非公開に変更</option>
                                        @elseif($item->items_status===1)
                                            <option value="1">現在：非公開</option>
                                            <option value="0">公開に変更</option>
                                        @endif
                                    </select>
                                </p>
                            </td>
                            <td class="search_word">{{ $item->search_word }}</td>
                            <td>
                                <input form="item{{ $item->id }}" type="submit" value="内容変更" class="btn btn-secondary mb-3">
                                <input form="item{{ $item->id }}" type="hidden" name="sqltype" value="detail_change">
                                <input form="item{{ $item->id }}" type="hidden" name="id" value="{{ $item->id }}">
                                
                                <form id="delete{{ $item->id }}" action="deleteItem" method="post" enctype="multipart/form-data">@csrf</form>
                                <input form="delete{{ $item->id }}" type="submit" value="削除" class="btn btn-danger delete">
                                <input form="delete{{ $item->id }}" type="hidden" name="item_id" value="{{ $item->id }}">
                                <input form="delete{{ $item->id }}" type="hidden" name="deletefiles" value="{{ $item->img }}">
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-make-item" role="tabpanel" aria-labelledby="nav-make-item-tab">
            <div class="card rounded-0 border-top-0">
                <div class="card-body">
                    <div class="form">
                        <form action="createItem" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">トレーニング名:</label>
                                <input class="form-control w-50" type="text" name="item_name" id="name">    
                            </div>
                            <div class="form-group">
                                <label for="creator">作者名:</label>
                                <input class="form-control w-50" type="text" name="creator" id="creator" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="form-group">
                                <label for="caption">説明文:　※改行ごとに番号が付きます。</label>
                                <textarea class="form-control w-50 h-150px" type="text" name="caption" id="caption"></textarea>
                            </div>
                            <div class="my-3">
                                <p class="mb-1">検索ワード:　※入力後の変更はできません。</p>
                                <div class="mx-3 my-2">
                                    部位<br>
                                    <input type="checkbox" name="search_word[]" id="neck" value="頸部">
                                    <label for="neck">頸部</label>
                                    <input type="checkbox" name="search_word[]" id="shoulder" value="肩関節">
                                    <label for="shoulder">肩関節</label>
                                    <input type="checkbox" name="search_word[]" id="waist" value="腰部">
                                    <label for="waist">腰部</label>
                                    <input type="checkbox" name="search_word[]" id="hip" value="股関節">
                                    <label for="hip">股関節</label>
                                    <input type="checkbox" name="search_word[]" id="knee" value="膝関節">
                                    <label for="knee">膝関節</label>
                                    <input type="checkbox" name="search_word[]" id="ankle" value="足部">
                                    <label for="ankle">足部</label>
                                </div>
                                <div class="mx-3 my-2">
                                    病名<br>
                                    <input type="checkbox" name="search_word[]" id="periarthritisOfTheShoulder" value="肩関節周囲炎">
                                    <label for="periarthritisOfTheShoulder">肩関節周囲炎</label>
                                    <input type="checkbox" name="search_word[]" id="spinalCanalStenosis" value="腰部脊柱管狭窄症">
                                    <label for="spinalCanalStenosis">腰部脊柱管狭窄症</label>
                                    <input type="checkbox" name="search_word[]" id="lumbarDiscHerniation" value="腰椎椎間板ヘルニア">
                                    <label for="lumbarDiscHerniation">腰椎椎間板ヘルニア</label>
                                    <input type="checkbox" name="search_word[]" id="osteoarthritisOfTheHip" value="変形性股関節症">
                                    <label for="osteoarthritisOfTheHip">変形性股関節症</label>
                                    <input type="checkbox" name="search_word[]" id="osteoarthritisOfTheKnee" value="変形性膝関節症">
                                    <label for="osteoarthritisOfTheKnee">変形性膝関節症</label>
                                </div>
                                <div class="mx-3 my-2">
                                    介護部門<br>
                                    <input type="checkbox" name="search_word[]" id="standing" value="立位での体操">
                                    <label for="standing">立位での体操</label>
                                    <input type="checkbox" name="search_word[]" id="sitting" value="座位での体操">
                                    <label for="sitting">座位での体操</label>
                                    <input type="checkbox" name="search_word[]" id="bed" value="ベッドでの体操">
                                    <label for="bed">ベッドでの体操</label>
                                    <input type="checkbox" name="search_word[]" id="ceraBand" value="セラバンド体操">
                                    <label for="ceraBand">セラバンド体操</label>
                                    <input type="checkbox" name="search_word[]" id="stick" value="棒体操">
                                    <label for="stick">棒体操</label>
                                </div>
                                <div class="mx-3 my-2">
                                    フリーワード欄　※複数記載する場合は「、」で区切ってください。<br>
                                    <input class="form-control w-50" type="text" name="search_word[]">
                                </div>
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
        </div>
        <div class="tab-pane fade show" id="nav-template-catalog" role="tabpanel" aria-labelledby="nav-template-catalog-tab">
            <div class="contents">
                <table class="table table-bordered text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>テンプレート名</th>
                            <th>作者名</th>
                            <th>トレーニング内容</th>
                            <th>種類</th>
                            <th>ステータス</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    @foreach($templates as $key => $template)
                    <tr>
                        <td>
                            @if($admin === 'admin')
                                ユーザーID: {{ $template[0]->user_id }}<br>
                            @endif

                            {{ $template[0]->template_name }}
                        </td>
                        <td>
                            {{ $template[0]->creator}}
                        </td>
                        <td>
                            @foreach($template as $val)
                                {{ $val -> item_name }}<br>
                            @endforeach
                        </td>
                        <td>
                            @if($template[0]->kind === 'body_parts')
                            <p>部位</p>
                            @elseif($template[0]->kind === 'disease_name')
                            <p>病名</p>
                            @elseif($template[0]->kind === 'care_prevention')
                            <p>介護予防</p>
                            @endif
                        </td>
                        <td>
                            @if($template[0]->templates_status===0)
                            <p>公開</p>
                            @elseif($template[0]->templates_status===1)
                            <p>非公開</p>
                            @endif
                        </td>
                        <td>
                            <form action="deleteTemplate" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="submit" value="削除" class="btn btn-danger delete">
                                <input type="hidden" name="templates_id" value="{{ $template[0]->templates_id }}">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-make-template" role="tabpanel" aria-labelledby="nav-make-template-tab">
            <div class="card rounded-0 border-top-0">
                <div class="card-body">
                    <div class="form">
                        <form action="createTemplate" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="mb-0" for="template">テンプレート名</label>
                                <input class="form-control w-50" type="text" name="template_name" id="template">
                                <label class="mb-0 mt-3" for="template_creator">作者名</label>
                                <input class="form-control w-50" type="text" name="template_creator" value="{{ Auth::user()->name }}">
                                <label class="mb-0 mt-3" for="template_status">テンプレートの公開設定</label>
                                <select class="form-control w-100px" name="template_status" id="template_status">
                                    <option value="0">公開</option>
                                    <option value="1">非公開</option>
                                </select>
                                <label class="mb-0 mt-3" for="template_kind">テンプレート種類</label>
                                <div class="form-group">
                                    <input type="radio" name="template_kind" value="care_prevention" id="care_prevention">
                                    <label for="care_prevention">介護予防</label>
                                    <input type="radio" name="template_kind" value="disease_name" id="disease_name">
                                    <label for="disease_name">病名</label>
                                    <input type="radio" name="template_kind" value="body_parts" id="body_parts">
                                    <label for="body_parts">部位別</label>
                                    <input type="radio" name="template_kind" value="etc" id="etc">
                                    <label for="etc">その他</label>
                                </div>
                                <label class="mb-0 mt-3" for="item-choice">トレーニング選択　※3つまで選択可能</label>
                                <div class="form-group d-flex row" id="item-choice">
                                    <p class="col-12 mb-0">オリジナルトレーニング</p>
                                    @foreach($item_list_for_template as $item)
                                        @if($item->user_id !== $admin_id)
                                            <div class="col-2 col-lg-2">
                                                <input type="checkbox" name="template_items[]" id="{{ $item->id }}{{ $item->item_name }}" value="{{ $item->id }}">
                                                <label class="template_choice_item" for="{{ $item->id }}{{ $item->item_name }}">
                                                    {{ $item->item_name }}
                                                    <img width="100px" height="auto" src="/storage/img/{{ $item->img}}" alt="{{ $item->item_name }}"> 
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                    <p class="col-12 mb-0">共通トレーニング</p>
                                    @foreach($item_list_for_template as $item)
                                        @if($item->user_id === $admin_id)
                                            <div class="col-2 col-lg-2">
                                                <input type="checkbox" name="template_items[]" id="{{ $item->id }}{{ $item->item_name }}" value="{{ $item->id }}">
                                                <label class="template_choice_item" for="{{ $item->id }}{{ $item->item_name }}">
                                                    {{ $item->item_name }}
                                                    <img width="100px" height="auto" src="/storage/img/{{ $item->img}}" alt="{{ $item->item_name }}"> 
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <p><input class="btn btn-primary"type="submit" value="テンプレート作成"></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection