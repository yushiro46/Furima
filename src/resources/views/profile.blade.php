@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="mypage-container">

    <!-- プロフィール部分 -->
    <div class="profile-area">

        @if ($user->avatar)
        <div class="user-icon">
            <img src="{{ asset('avatars/' . $user->avatar) }}" class="user-icon-img" alt="ユーザーアイコン">
        </div>
        @else
        <div class="user-icon"></div>
        @endif

        <!-- ユーザー情報 -->
        <div class="user-info">
            <p class="user-name">{{ $user->name }}</p>

            <a href="/mypage/profile" class="edit-profile-btn">プロフィールを編集</a>
        </div>

        <!-- ナビゲーションボタン -->
        <div class="mypage-nav">
            <a href="/mypage?page=sell"
                class="nav-btn {{ request('page', 'sell') === 'sell' ? 'active' : '' }}">
                出品した商品
            </a>

            <a href="/mypage?page=buy"
                class="nav-btn {{ request('page') === 'buy' ? 'active' : '' }}">
                購入した商品
            </a>
        </div>
    </div>

    <hr class="mypage-line">

    <!-- 商品一覧 -->
    <div class="item-list">
        @foreach ($items as $item)
        <div class="item-card">
            <img src="{{ asset('storage/products/' . $item->image) }}" class="item-image" alt="商品画像">
            <p class="item-name">{{ $item->name }}</p>
        </div>
        @endforeach
    </div>

</div>

@endsection