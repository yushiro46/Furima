<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECHフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}" />
</head>

<body>
    <header class="header">
        <div class="header-left">
            <img src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}" alt="ロゴ" class="logo">
        </div>
    </header>

    <main>
        <div class="verify">

            <p class="verify__message">
                登録していただいたメールアドレスに認証メールを送付しました。<br>
                メール認証を完了してください。
            </p>

            {{-- メールを確認したあとに押す想定 --}}
            <a href="/profile/setup" class="verify__primary-btn">
                認証はこちらから
            </a>

            {{-- 認証メール再送 --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="verify__resend-btn">
                    認証メールを再送する
                </button>
            </form>

            @if (session('status') === 'verification-link-sent')
            <p class="verify__status">認証メールを再送しました。</p>
            @endif

        </div>

    </main>
</body>

</html>