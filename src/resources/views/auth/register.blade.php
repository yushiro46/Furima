<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <mete http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>COACHTECHフリマ</title>
        <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
    <header class="header">
        <div class="header-left">
            <img src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}" alt="ロゴ" class="logo">
        </div>
    </header>

    <main>
        <div class="register-container">
            <h2 class="register-title">会員登録</h2>

            <form class="register-form" action="/register" method="post">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">ユーザー名</label>
                    <input class="form-input" type="text" id="name" name="name" value="{{ old('name') }}">
                    <div class="form__error">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">メールアドレス</label>
                    <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}">
                    <div class="form__error">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">パスワード</label>
                    <input class="form-input" type="password" id="password" name="password">
                    <div class="form__error">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">確認用パスワード</label>
                    <input class="form-input" type="password" id="password_confirmation" name="password_confirmation">
                </div>

                <div class="form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>

                <div class="form-button">
                    <button class="register-submit" type="submit">登録する</button>
                </div>
            </form>

            <div class="login-link">
                <a class="login-link__text" href="/login">ログインはこちら</a>
            </div>
        </div>
    </main>

</body>

</html>