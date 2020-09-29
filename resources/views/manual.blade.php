@extends('layouts.common')

@section('title')
<title>使い方：Reha Menu</title>
@endsection

@section('pageCss')
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@include('layouts.nav')

@section('content')
<main>
    <div class="container pt-5 mt-5">
        <div class="text-center">
            <h1>使い方ガイド</h1>
        </div>
        <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">トレーニング用紙作成&編集(PC版)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">トレーニング用紙作成&編集(スマホ版)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">オリジナルトレーニング作成</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="card">
                    <div class="card-body">
                        <h2 class="h3 text-center">トレーニング用紙作成（PC版）</h2>
                        <div class="mb-4">
                            <h3 class="h4">ステップ1：トレーニングを選択する</h3>
                            <div class="d-flex row pl-4">
                                <ol type="1" class="col-12 col-lg-6">
                                    <li>画面左側のトレーニング追加もしくはテンプレートをクリックすると、右横にトレーニングが一覧表示されます。</li>
                                    <li>トレーニングの画像をクリックすると画面右のプレビューにトレーニングが表示されます。<br>
                                    テンプレートをクリックした場合は最大3つまでプレビューに表示されます。</li>
                                    <li>メニュー数選択ボタンでメニュー数を1～3まで選択できます。</li>
                                </ol>
                                <img class="col-12 col-lg-6 img-fluid img-thumbnail" src="./img/manualimg1.png" alt="使い方説明画像1">
                            </div>
                        </div>
                        <div class="mb-4">
                            <h3 class="h4">ステップ2：トレーニングの編集&削除をする</h3>
                            <div class="d-flex row pl-4">
                                <ol type="1" class="col-12 col-lg-6">
                                    <li>自主トレのタイトルやトレーニング名、説明文をクリックすることで内容の変更が可能です。</li>
                                    <li>トレーニング左上の削除ボタンを押すことで選択したトレーニングの削除ができます。</li>
                                </ol>
                                <img class="col-12 col-lg-6 img-fluid img-thumbnail" src="./img/manualimg2.png" alt="使い方説明画像2">
                            </div>
                        </div>
                        <div class="mb-2">
                            <h3 class="h4">ステップ3：トレーニングの印刷&ダウンロードをする</h3>
                            <div class="d-flex row pl-4">
                                <ol type="1" class="col-12 col-lg-6">
                                    <li>画面右上の印刷もしくはダウンロードボタンを押します。</li>
                                    <li>印刷の場合は印刷プレビューを確認して印刷をします。</li>
                                </ol>
                                <img class="col-12 col-lg-6 img-fluid img-thumbnail" src="./img/manualimg2.png" alt="使い方説明画像2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="card">
                    <div class="card-body">
                        <h2 class="h3 text-center">トレーニング用紙作成（スマホ版）</h2>
                        <div class="mb-4">
                            <h3 class="h4">ステップ1：トレーニングを選択する</h3>
                            <div class="d-flex row pl-4">
                                <ol type="1" class="col-12 col-lg-6">
                                    <li>トレーニング選択をタッチすると、下から一覧が表示されます。</li>
                                    <li>トレーニングの画像をタッチすると画面中央のプレビューにトレーニングが表示されます。</li>
                                    <li>テンプレートに切り替えて画像をタッチすると場合は最大3つまでプレビューに表示されます。</li>
                                    <li>右上の横3本線のタグをタッチすると、メニュー数選択、ダウンロード、印刷、ログイン、新規登録ができます。</li>
                                </ol>
                                <img class="col-12 col-lg-6 img-fluid img-thumbnail" src="./img/manualimg4.png" alt="使い方説明画像4">
                            </div>
                        </div>
                        <div class="mb-4">
                            <h3 class="h4">ステップ2：トレーニングの編集&削除をする</h3>
                            <div class="d-flex row pl-4">
                                <ol type="1" class="col-12 col-lg-6">
                                    <li>自主トレのタイトルやトレーニング名、説明文をタッチすることで内容の変更が可能です。</li>
                                    <li>トレーニング左上の削除ボタンをタッチすることで選択したトレーニングの削除ができます。</li>
                                </ol>
                                <img class="col-12 col-lg-6 img-fluid img-thumbnail" src="./img/manualimg5.png" alt="使い方説明画像5">
                            </div>
                        </div>
                        <div class="mb-2">
                            <h3 class="h4">ステップ3：トレーニングの印刷&ダウンロードをする</h3>
                            <div class="d-flex row pl-4">
                                <ol type="1" class="col-12 col-lg-6">
                                    <li>画面右上の横3本線をタッチします。</li>
                                    <li>印刷もしくはダウンロードボタンをタッチします。</li>
                                    <li>印刷の場合は印刷プレビューを確認して印刷をします。</li>
                                </ol>
                                <img class="col-12 col-lg-6 img-fluid img-thumbnail" src="./img/manualimg6.png" alt="使い方説明画像6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            <div class="card">
                    <div class="card-body">
                        <h2 class="h3 text-center">オリジナルトレーニング作成</h2>
                        <p class="text-center">会員登録をするとオリジナルトレーニング&テンプレートの作成や他のユーザーとの共有ができます！公開されたトレーニングはログインしているユーザーが使用可能になります。</p>
                        <div class="mb-4">
                            <h3 class="h4">ステップ1：会員登録をする。</h3>
                            <div class="d-flex row pl-4">
                                <ol type="1" class="col-12 col-lg-6">
                                    <li>画面右上の新規登録をクリックします。(スマホの場合は右上の横3本線をタッチします。)</li>
                                    <li>必要事項を入力して会員登録をします。</li>
                                    <li>会員登録をしたら</li>
                                </ol>
                                <img class="col-12 col-lg-6 img-fluid img-thumbnail" src="./img/manualimg8.png" alt="使い方説明画像8">
                            </div>
                        </div>
                        <div class="mb-4">
                            <h3 class="h4">ステップ2：Myページに入る。</h3>
                            <div class="d-flex row pl-4">
                                <ol type="1" class="col-12 col-lg-6">
                                    <li>会員登録・ログインをすると画面左のナビゲーションバーにMyページの項目が追加されます。
                                    <br>(スマホの場合はトレーニング追加をタッチして表示される画面にMyページが追加されます。)</li>
                                    <li>クリックしてMyページに入ります。</li>
                                </ol>
                                <img class="col-12 col-lg-6 img-fluid img-thumbnail" src="./img/manualimg9.png" alt="使い方説明画像9">
                            </div>
                        </div>
                        <div class="mb-2">
                            <h3 class="h4">ステップ3：トレーニングを作成する。</h3>
                            <div class="d-flex row pl-4">
                                <ol type="1" class="col-12 col-lg-6">
                                    <li>画面中央のタグの中からトレーニング作成をクリックします。</li>
                                    <li>トレーニング名、作者名、説明文などを各項目を入力し、トレーニング作成ボタンをクリックします。</li>
                                    <li>作成するとMyページのトレーニング一覧に表示され、リハビリメニュー作成ページにも追加されます。
                                    <br>公開設定を公開にした場合はすべてのユーザーに公開されます。非公開の場合は作成者のログイン時のみ使用可能となります。</li>
                                    <li>Myページではトレーニング&テンプレートの作成、一覧表示が行なえます。</li>
                                </ol>
                                <img class="col-12 col-lg-6 img-fluid img-thumbnail" src="./img/manualimg7.png" alt="使い方説明画像7">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a type="button" class="btn btn-secondary w-100 mt-2 mb-4 text-light" href="{{ $return_url }}">元のページに戻る</a>
    </div>
</main>
@endsection

@include('layouts.footer')