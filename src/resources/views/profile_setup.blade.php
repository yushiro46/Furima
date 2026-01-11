@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile_setup.css') }}">
@endsection

@section('content')
<div class="profile-settings-container">

    <h2 class="profile-title">プロフィール設定</h2>

    <form action="/profile/setup" method="post" enctype="multipart/form-data" class="profile-form">
        @csrf

        <!-- アイコン画像選択 -->
        <div class="form-group">
            <label class="form-label">アイコン画像</label>
            <div class="icon-select">
                @if ($user->avatar)
                <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="現在のアイコン" class="icon-preview">
                @else
                <div class="icon-preview icon-preview--placeholder"></div>
                @endif

                <input type="file" name="avatar" class="icon-input">
            </div>
        </div>

        <div class="form__error">
            @error('avatar')
            {{ $message }}
            @enderror
        </div>

        <!-- ユーザーネーム表示 -->
        <div class="form-group">
            <label class="form-label">ユーザーネーム</label>
            <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}">
        </div>

        <div class="form__error">
            @error('name')
            {{ $message }}
            @enderror
        </div>

        <!-- 郵便番号 -->
        <div class="form-group">
            <label class="form-label">郵便番号</label>
            <input type="text" name="postal_code" class="form-input"
                value="{{ old('postal_code', $user->postal_code) }}">
        </div>

        <div class="form__error">
            @error('postal_code')
            {{ $message }}
            @enderror
        </div>

        <!-- 住所 -->
        <div class="form-group">
            <label class="form-label">住所</label>
            <input type="text" name="address" class="form-input"
                value="{{ old('address', $user->address) }}">
        </div>

        <div class="form__error">
            @error('address')
            {{ $message }}
            @enderror
        </div>
        
        <!-- 建物名 -->
        <div class="form-group">
            <label class="form-label">建物名（任意）</label>
            <input type="text" name="building" class="form-input"
                value="{{ old('building', $user->building) }}">
        </div>

        <!-- 更新ボタン -->
        <button type="submit" class="update-btn">更新する</button>
    </form>
</div>
@endsection