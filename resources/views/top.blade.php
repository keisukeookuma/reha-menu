@extends('layouts.common')

@section('title')
<title>Reha Menu:リハビリメニューの作成＆共有サイト</title>
@endsection

@section('description')
<meta name="description" content="運動指導者向けのトレーニング用紙の作成＆共有サイト。素敵なイラストを使ったトレーニング用紙の無料作成や自分の考えたトレーニングメニューの共有ができます！">
@endsection

@section('pageCss')
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@include('layouts.nav')

@section('content')
  <main>
    <header class="masthead text-center text-white">
      <div class="masthead-content">
        <div class="container">
          <h1 class="masthead-heading mb-0">Reha Menu</h1>
          <h2 class="masthead-subheading mb-0">リハビリメニューの作成＆共有サイト！</h2>
          <a href="{{ url('/index') }}" class="btn btn-primary btn-xl rounded-pill mt-5">作成ページへ</a>
        </div>
      </div>
    </header>

    <section class="bg-gradient text-white space-lg">
      <div class="container">

      </div>
    </section>

    <section>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 order-lg-2">
            <div class="p-5 text-center">
              <img class="img-fluid section-img-size" src="./img/topimg3.png" alt="簡単作成画像">
            </div>
          </div>
          <div class="col-lg-6 order-lg-1">
            <div class="p-5 font-20">
              <h2 class="lead">クリックで簡単作成</h2>
              <p>必要なトレーニングをクリックするだけで簡単にオリジナルの自主トレ用紙を作成できます。<br>部位別・病名別など様々なテンプレートもあります。<br>直感的な操作で簡単に作成できるため、日々の業務時間を短縮することができます！</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="p-5">
              <img class="img-fluid" src="./img/topimg5.png" alt="イラスト参考画像">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="p-5 font-20">
              <h2 class="lead">素敵なイラスト</h2>
              <p>Reha Menuのために書かれた素敵なイラストを使って、利用者に伝わる自主トレ用紙を作成することが出来ます。</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 order-lg-2">
            <div class="p-5">
              <img class="img-fluid section-img-size" src="./img/topimg2.png" alt="管理画面参考画像">
            </div>
          </div>
          <div class="col-lg-6 order-lg-1">
            <div class="p-5 font-20">
              <h2 class="lead">オリジナルメニューの追加＆共有可能！</h2>
              <p>会員登録をすることでトレーニングの作成や公開ができます。また、他のユーザーが作ったトレーニングを使うことも可能です。<br>
              あなたの考えた自主トレをみんなと共有しよう！</p>
              <p>もちろん、会員登録なしでもリハビリメニューの作成は可能です！</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection

@include('layouts.footer')