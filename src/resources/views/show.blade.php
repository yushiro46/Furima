@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="item-show">

    <div class="item-show__image">
        <img src="{{ asset('storage/products/' . $item->image) }}" alt="{{ $item->name }}">
    </div>

    <div class="item-show__info">

        <h1 class="item-show__name">{{ $item->name }}</h1>

        @if ($item->brand)
        <p class="item-show__brand">ブランド： {{ $item->brand }}</p>
        @endif

        <p class="item-show__price">¥{{ number_format($item->price) }}</p>

        <div class="item-show__icons">
            <form action="/item/{{ $item->id }}/like" method="post" class="like-form">
                @csrf
                <input type="hidden" name="like" value="1">

                <button type="submit" class="like-button">
                    @if ($item->likes->contains('user_id', auth()->id()))
                    <img src="{{ asset('images/ハートロゴ_ピンク.png') }}" class="icon-heart" alt="いいね">
                    @else
                    <img src="{{ asset('images/ハートロゴ_デフォルト.png') }}" class="icon-heart" alt="いいね">
                    @endif
                </button>
            </form>

            <span class="like-count">{{ $item->likes->count() }}</span>

            <div class="comment-icon-wrapper">
                <img src="{{ asset('images/ふきだしロゴ.png') }}" class="icon-comment" alt="コメント">
                <span class="comment-count">{{ $item->comments->count() }}</span>
            </div>
        </div>

        <a href="/purchase/{{ $item->id }}" class="purchase-btn">購入手続きへ</a>

        <div class="item-show__description">
            <h2>商品の説明</h2>

            <p>{{ $item->description }}</p>

            <p>
                <strong>カテゴリー：</strong>
                @if ($item->categories->isNotEmpty())
                @foreach ($item->categories as $category)
                <span class="item-show__category-tag">{{ $category->name }}</span>
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

        <div class="item-show__comment-area">
            <h2>コメント</h2>

            @foreach ($item->comments as $comment)
            <div class="comment-row">
                <strong>{{ $comment->user->name }}</strong>
                <p>{{ $comment->comment }}</p>
            </div>
            @endforeach

            <form action="/item/{{ $item->id }}/comment" method="post">
                @csrf
                <textarea name="comment" class="comment-input" placeholder="商品へのコメントを入力"></textarea>

                <div class="form__error">
                    @error('comment')
                    {{ $message }}
                    @enderror
                </div>

                <button type="submit" name="action" value="comment" class="comment-submit-btn">
                    コメントを送信する
                </button>
            </form>
        </div>
    </div>
</div>
@endsection