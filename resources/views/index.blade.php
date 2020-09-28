@extends('layouts.common')

@section('title')
<title>リハビリメニューの作成！：Reha Menu</title>
@endsection

@section('pageCss')
<link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endsection

@section('content')
    <header class="navbar navbar-dark fixed-top flex-nowrap p-0 shadow navbar-expand-lg">
        <div class="header-container px-3 w-100">
            <div class="navbar-brand ml-2">
                <a class="mr-0 " href="{{ url('/') }}">Reha Menu</a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <ul class="navbar-nav px-3">
                        <li class="menu-change d-flex justify-content-center">
                            <p class="nav-link m-0">メニュー数:</p>
                            <ul class="nav nav-pills">
                                <li><a id="choice-contents-1" class="nav-link px-2 mx-1" data-toggle="pill" href="#" role="tab">1</a></li>
                                <li><a id="choice-contents-2" class="nav-link px-2 mx-1" data-toggle="pill" href="#" role="tab">2</a></li>
                                <li><a id="choice-contents-3" class="nav-link active px-2 mx-1" data-toggle="pill" href="#" role="tab">3</a></li>
                            </ul>
                        </li>
                    </ul>
                    <li class="nav-item">
                        <a class="downloadBtn nav-link text-center" href="#">ダウンロード</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center" href="#" id="print">印刷</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-center" href="{{ route('login') }}">ログイン</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-center" href="{{ route('register') }}">新規登録</a>
                        </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-center" href="#">{{ Auth::user()->name }}様</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                ログアウト
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid noprint">
        <div class="row pt-5">
            <nav class="hamburger-nav col-md-6 col-lg-5 px-0">
                <div class="nav-side col-md-4 col-lg-3 d-md-block pt-2 px-0">
                    <div class="nav nav-pills px-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active nav-a-size px-0 text-center m-auto" data-toggle="pill" href="#v-pills-original" role="tab" aria-controls="v-pills-original" aria-selected="true">
                            <svg class="bi bi-plus-square" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 3.5a.5.5 0 01.5.5v4a.5.5 0 01-.5.5H4a.5.5 0 010-1h3.5V4a.5.5 0 01.5-.5z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M7.5 8a.5.5 0 01.5-.5h4a.5.5 0 010 1H8.5V12a.5.5 0 01-1 0V8z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M14 1H2a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V2a1 1 0 00-1-1zM2 0a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V2a2 2 0 00-2-2H2z" clip-rule="evenodd"/>
                            </svg>  
                            <p>トレーニング追加</p>
                        </a>
                        <a class="template_all nav-link nav-a-size px-0 pt-3 text-center m-auto" data-toggle="pill" href="#v-pills-sample1" role="tab" aria-controls="v-pills-sample1" aria-selected="false">
                            <svg class="bi bi-textarea-t" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M14 9a1 1 0 100-2 1 1 0 000 2zm0 1a2 2 0 100-4 2 2 0 000 4zM2 9a1 1 0 100-2 1 1 0 000 2zm0 1a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M1.5 2.5A1.5 1.5 0 013 1h10a1.5 1.5 0 011.5 1.5v4h-1v-4A.5.5 0 0013 2H3a.5.5 0 00-.5.5v4h-1v-4zm1 7v4a.5.5 0 00.5.5h10a.5.5 0 00.5-.5v-4h1v4A1.5 1.5 0 0113 15H3a1.5 1.5 0 01-1.5-1.5v-4h1z" clip-rule="evenodd"/>
                                <path d="M11.434 4H4.566L4.5 5.994h.386c.21-1.252.612-1.446 2.173-1.495l.343-.011v6.343c0 .537-.116.665-1.049.748V12h3.294v-.421c-.938-.083-1.054-.21-1.054-.748V4.488l.348.01c1.56.05 1.963.244 2.173 1.496h.386L11.434 4z"/>
                            </svg>
                            <p>テンプレート</p>
                        </a>
                        @guest
                        <a class="nav-link nav-a-size px-0 text-center pt-3 m-auto" href="{{ url('/manual') }}">
                            <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-book" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M1 2.828v9.923c.918-.35 2.107-.692 3.287-.81 1.094-.111 2.278-.039 3.213.492V2.687c-.654-.689-1.782-.886-3.112-.752-1.234.124-2.503.523-3.388.893zm7.5-.141v9.746c.935-.53 2.12-.603 3.213-.493 1.18.12 2.37.461 3.287.811V2.828c-.885-.37-2.154-.769-3.388-.893-1.33-.134-2.458.063-3.112.752zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                            </svg>
                            <p>使い方ガイド</p>
                        </a>
                        <a class="nav-link nav-a-size px-0 pt-3 text-center m-auto"  href="{{ url('/opinion') }}">
                            <svg class="bi bi-inbox-fill" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3.81 4.063A1.5 1.5 0 014.98 3.5h6.04a1.5 1.5 0 011.17.563l3.7 4.625a.5.5 0 01-.78.624l-3.7-4.624a.5.5 0 00-.39-.188H4.98a.5.5 0 00-.39.188L.89 9.312a.5.5 0 11-.78-.624l3.7-4.625z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M.125 8.67A.5.5 0 01.5 8.5h5A.5.5 0 016 9c0 .828.625 2 2 2s2-1.172 2-2a.5.5 0 01.5-.5h5a.5.5 0 01.496.562l-.39 3.124a1.5 1.5 0 01-1.489 1.314H1.883a1.5 1.5 0 01-1.489-1.314l-.39-3.124a.5.5 0 01.121-.393z" clip-rule="evenodd"/>
                            </svg>
                            <p>ご意見箱</p>
                        </a>
                        @endguest
                        @auth
                        <a class="nav-link nav-a-size px-0 text-center pt-3 m-auto" data-toggle="pill" href="#v-pills-info" role="tab" aria-controls="v-pills-info" aria-selected="false">
                            <svg class="bi bi-info-square" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                            <circle cx="8" cy="4.5" r="1"/>
                            </svg>
                            <p>info</p>
                        </a>
                        <a class="nav-link nav-a-size px-0 text-center pt-3 m-auto" href="{{ url('/tool') }}">
                            <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-file-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M12 1H4a1 1 0 0 0-1 1v10.755S4 11 8 11s5 1.755 5 1.755V2a1 1 0 0 0-1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                                <path fill-rule="evenodd" d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                            <p>Myページリンク</p>
                        </a>
                        @endauth
                    </div>
                </div>
                <div class="hamburger-item-choice col-md-8 col-lg-9 d-md-block pt-2 px-1 overflow-auto">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-original" role="tabpanel" aria-labelledby="v-pills-original-tab">
                            <div class="search mx-auto">
                                <input class="search-form form-control" type="text" placeholder="タイトル,実施姿勢,関節名,作者名で検索可能！" aria-label="検索">
                            </div>
                            <div class="overflow-auto search-item-height">
                                <ul id="all_show_result" class="d-flex flex-wrap justify-content-around pt-1"></ul>
                                <div class="view_more text-center"><button class='btn'>もっと見る</button></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-sample1" role="tabpanel" aria-labelledby="v-pills-sample1-tab">
                            <div class="template_search mx-auto mb-1">
                                <select class="custom-select" id="validationTooltip04" required>
                                    <option selected value="">すべて表示</option>
                                    @auth
                                    <option value="{{ Auth::user()->id }}">オリジナル</option>
                                    @endauth
                                    <option value="locomotor_disorders">運動器疾患</option>
                                    <option value="cerebrovascular_disease">脳血管疾患</option>
                                    <option value="body_parts">部位別</option>
                                    <option value="care_prevention">介護予防</option>
                                    <option value="etc">その他</option>
                                </select>
                            </div>
                            <div class="overflow-auto search-item-height mb-1">
                                <ul id="template_list" class="px-1 pt-3 text-center"></ul>
                                <div class="template_view_more text-center"><button class='btn'>もっと見る</button></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-info" role="tabpanel" aria-labelledby="v-pills-info-tab">
                            <a class="nav-link h6 px-0 info-text text-center pt-3 m-auto" href="{{ url('/manual') }}">
                                <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-book" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1 2.828v9.923c.918-.35 2.107-.692 3.287-.81 1.094-.111 2.278-.039 3.213.492V2.687c-.654-.689-1.782-.886-3.112-.752-1.234.124-2.503.523-3.388.893zm7.5-.141v9.746c.935-.53 2.12-.603 3.213-.493 1.18.12 2.37.461 3.287.811V2.828c-.885-.37-2.154-.769-3.388-.893-1.33-.134-2.458.063-3.112.752zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                                </svg>
                                </svg>
                                <p>使い方ガイド</p>
                            </a>
                            <a class="nav-link h6 px-0 pt-3 info-text text-center m-auto"  href="{{ url('/opinion') }}">
                                <svg class="bi bi-inbox-fill" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M3.81 4.063A1.5 1.5 0 014.98 3.5h6.04a1.5 1.5 0 011.17.563l3.7 4.625a.5.5 0 01-.78.624l-3.7-4.624a.5.5 0 00-.39-.188H4.98a.5.5 0 00-.39.188L.89 9.312a.5.5 0 11-.78-.624l3.7-4.625z" clip-rule="evenodd"/>
                                    <path fill-rule="evenodd" d="M.125 8.67A.5.5 0 01.5 8.5h5A.5.5 0 016 9c0 .828.625 2 2 2s2-1.172 2-2a.5.5 0 01.5-.5h5a.5.5 0 01.496.562l-.39 3.124a1.5 1.5 0 01-1.489 1.314H1.883a1.5 1.5 0 01-1.489-1.314l-.39-3.124a.5.5 0 01.121-.393z" clip-rule="evenodd"/>
                                </svg>
                                <p>ご意見箱</p>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
            <main role="main" class="col-md-6 col-lg-7 ml-sm-auto pt-2 px-0 ">
                <div class="preview-scroll ">
                    <div class="container responsive-mb">
                        <div class="tab-content p-3 d-flex justify-content-center">
                            <div id="preview" class="tab-pane fade show active m-0">
                                <h1 class="text-center" contentEditable="true">リハビリメニュー</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div class="hamburger-menu d-md-none">
            <div class="menu-trigger" href="#">
            <p>トレーニング選択</p>
            </div>
        </div>
    </div>
    <div class="print-preview">
        <img src="" alt="" id="canvas-image">
    </div>
    <script src="{{ asset('js/index_function.js') }}" defer></script>
    <script src="{{ asset('js/index.js') }}" defer></script>
    <script src="{{ asset('js/index_responsive.js') }}" defer></script>
    <script src="{{ asset('js/html2canvas.min.js') }}" defer></script>
    <script src="{{ asset('js/index_print.js') }}" defer></script>
@endsection