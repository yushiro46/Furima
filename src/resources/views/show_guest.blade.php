@extends('layouts.guest')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show_guest.css') }}">
@endsection

@section('content')
<div class="item-show">

    {{-- 左側：商品画像 --}}
    <div class="item-show__image">
        <img src="{{ asset('storage/products/' . $item->image) }}" alt="{{ $item->name }}">
    </div>

    {{-- 右側：商品情報 --}}
    <div class="item-show__info">

        {{-- 商品名 --}}
        <h1 class="item-show__name">{{ $item->name }}</h1>

        {{-- ブランド名 --}}
        @if ($item->brand)
        <p class="item-show__brand">ブランド：{{ $item->brand }}</p>
        @endif

        {{-- 金額 --}}
        <p class="item-show__price">¥{{ number_format($item->price) }}</p>

        {{-- ハート（いいね）と吹き出し（コメント） --}}
        <div class="item-show__icons">
            @if(Auth::check())
            <form action="{{ route('item.like', $item->id) }}" method="post">
                @csrf
                <button type="submit" class="like-button">
                    @if ($item->likes->contains('user_id', auth()->id()))
                    <img src="{{ asset('images/ハートロゴ_ピンク.png') }}" class="icon-heart">
                    @else
                    <img src="{{ asset('images/ハートロゴ_デフォルト.png') }}" class="icon-heart">
                    @endif
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="like-button">
                @if ($item->likes->count() > 0)
                <img src="{{ asset('images/ハートロゴ_ピンク.png') }}" class="icon-heart">
                @else
                <img src="{{ asset('images/ハートロゴ_デフォルト.png') }}" class="icon-heart">
                @endif
            </a>
            @endif


            <span class="like-count">{{ $item->likes->count() }}</span>

            <img src="{{ asset('images/ふきだしロゴ.png') }}" class="icon-comment" alt="コメント">

            <span class="comment-count">{{ $item->comments->count() }}</span>
        </div>

        {{-- 購入ボタン --}}
        <a href="{{ route('login') }}" class="purchase-btn">購入手続きへ</a>

        {{-- 商品説明 --}}
        <div class=" item-show__description">
            <h2>商品の説明</h2>
            <p>{{ $item->description }}</p>
        </div>

        {{-- 商品情報 --}}
        <div class="item-show__details">
            <h2>商品の情報</h2>

            <p>
                <strong>カテゴリー：</strong>
                @if ($item->categories->isNotEmpty())
                @foreach ($item->categories as $category)
                <span class="item-show__category-tag">
                    {{ $category->name }}
                </span>
                @endforeach
                @else
                <span>カテゴリ未設定</span>
                @endif
            </p>

            <p>
                <strong>商品の状態：</strong>
                {{ optional($item->condition)->name ?? '不明' }}
            </p>
        </div>

        {{-- コメント欄 --}}
        <div class="item-show__comment-area">
            <h2>コメント</h2>

            @foreach ($item->comments as $comment)
            <div class="comment-row">
                <strong>{{ $comment->user->name }}</strong>
                <p>{{ $comment->comment }}</p>
            </div>
            @endforeach
            <textarea class="comment-input" placeholder="商品へのコメントを入力"></textarea>

            <a href="{{ route('login') }}" class="comment-submit-btn">コメントを送信する
            </a>
        </div>

    </div>

</div>
@endsection