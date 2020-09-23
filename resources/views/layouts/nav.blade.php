@section('nav')
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand text-capitalize" href="{{ url('/') }}">Reha Menu</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-center" href="{{ url('/opinion') }}">使い方ガイド</a>
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
</nav>
@endsection