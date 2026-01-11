@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile_edit.css') }}">
@endsection

@section('content')
<div class="profile-settings-container">

    <h2 class="profile-title">プロフィール設定</h2>

    <form action="/mypage/profile" method="post" enctype="multipart/form-data" class="profile-form">
        @csrf

        <!-- アイコン画像 -->
        <div class="form-group">
            <label class="form-label">アイコン画像</label>
            <div class="icon-select">
                @if ($user->avatar)
                <img src="{{ asset('storage/avatars/' . $user->avatar) }}" class="icon-preview" id="preview-image">
                @else
                <img class="icon-preview icon-preview--placeholder" id="preview-image">
                @endif

                <span id="preview-text" @if($user->avatar) @endif>画像を選択してください</span>

                <input type="file" name="avatar" class="icon-input" accept="image/*" onchange="previewImage(this)">
            </div>
        </div>

        <div class="form__error">
            @error('avatar')
            {{ $message }}
            @enderror
        </div>

        <!-- ユーザーネーム（編集可） -->
        <div class="form-group">
            <label class="form-label">ユーザーネーム</label>
            <input
                type="text"
                name="name"
                class="form-input"
                value="{{ old('name', $user->name) }}">
        </div>

        <div class="form__error">
            @error('name')
            {{ $message }}
            @enderror
        </div>

        <!-- 郵便番号 -->
        <div class="form-group">
            <label class="form-label">郵便番号</label>
            <input
                type="text"
                name="postal_code"
                class="form-input"
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
            <input
                type="text"
                name="address"
                class="form-input"
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
            <input
                type="text"
                name="building"
                class="form-input"
                value="{{ old('building', $user->building) }}">
        </div>

        <!-- 更新ボタン -->
        <button type="submit" class="update-btn">更新する</button>
    </form>

    <script>
        function previewImage(input) {
            const file = input.files[0];
            if (!file) return;

            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.getElementById('preview-image');
                const text = document.getElementById('preview-text');

                img.src = e.target.result;
                img.classList.remove('is-hidden');
                text.classList.add('is-hidden');
            };

            reader.readAsDataURL(file);
        }
    </script>

</div>

@endsection