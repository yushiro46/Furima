<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <mete http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>COACHTECHフリマ</title>
        <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/common.css') }}">
        @yield('css')
</head>

<body>
    <header class="header">
        <div class="header-left">
            <img src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}" alt="ロゴ" class="logo">
        </div>

        <div class="header-center">
            <form action="/search" method="get" class="search-form">
                <input type="text" name="keyword" placeholder="なにをお探しですか？" class="search-input">
            </form>
        </div>

        <div class="header-right">
            <a href="/login" class="login-btn">ログイン</a>
            <a href="/mypage" class="mypage-btn">マイページ</a>
            <a href="/sell" class="sell-btn">出品</a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>