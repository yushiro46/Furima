@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="product-create-container">

    <h2 class="page-title">商品の出品</h2>

    <form action="/items" method="post" enctype="multipart/form-data" class="product-form">
        @csrf

        {{-- 商品画像 --}}
        <div class="form-section">
            <label class="form-label">商品画像</label>
            <div class="image-upload">
                <div class="image-preview">
                    <img id="preview-image" class="preview-image">
                    <span id="preview-text" class="preview-text">画像を選択してください</span>
                </div>
                <input type="file" name="image" class="image-input" accept="image/*" onchange="previewImage(this)">
            </div>
        </div>


        <div class="form__error">
            @error('image')
            {{ $message }}
            @enderror
        </div>

        {{-- 商品の詳細 --}}
        <div class="form-section">
            <h3 class="section-title">商品の詳細</h3>
            <hr class="section-line">

            {{-- カテゴリー --}}
            <div class="field">
                <p class="field-label">カテゴリー</p>
                <div class="category-list">
                    @foreach ($categories as $category)
                    <label class="category-pill">
                        <input
                            type="checkbox"
                            name="category_ids[]"
                            value="{{ $category->id }}"
                            {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }}>
                        <span>{{ $category->name }}</span>
                    </label>
                    @endforeach
                </div>

            </div>

            <div class="form__error">
                @error('category_ids')
                {{ $message }}
                @enderror
            </div>

            {{-- 商品の状態 --}}
            <div class="field">
                <label class="field-label" for="condition_id">商品の状態</label>
                <select name="condition_id" id="condition_id" class="select-input">
                    <option value="" hidden>選択してください</option>
                    @foreach ($conditions as $condition)
                    <option
                        value="{{ $condition->id }}"
                        {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                        {{ $condition->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form__error">
                @error('condition_id')
                {{ $message }}
                @enderror
            </div>
        </div>

        {{-- 商品名と説明 --}}
        <div class="form-section">
            <h3 class="section-title">商品名と説明</h3>
            <hr class="section-line">

            <div class="field">
                <label class="field-label" for="name">商品名</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="text-input"
                    value="{{ old('name') }}">
            </div>

            <div class="form__error">
                @error('name')
                {{ $message }}
                @enderror
            </div>

            <div class="field">
                <label class="field-label" for="brand">ブランド名</label>
                <input
                    type="text"
                    id="brand"
                    name="brand"
                    class="text-input"
                    value="{{ old('brand') }}">
            </div>

            <div class="field">
                <label class="field-label" for="description">商品の説明</label>
                <textarea
                    id="description"
                    name="description"
                    class="textarea-input"
                    rows="5">{{ old('description') }}</textarea>
            </div>

            <div class="form__error">
                @error('description')
                {{ $message }}
                @enderror
            </div>

            <div class="field">
                <label class="field-label" for="price">販売価格</label>
                <div class="price-input-wrapper">
                    <span class="price-prefix">￥</span>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        class="price-input"
                        min="0"
                        step="1"
                        value="{{ old('price') }}">
                </div>
            </div>

            <div class="form__error">
                @error('price')
                {{ $message }}
                @enderror
            </div>
        </div>

        {{-- 出品ボタン --}}
        <div class="form-actions">
            <button type="submit" class="submit-btn">出品する</button>
        </div>
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
                img.style.display = 'block'; // 表示
                text.style.display = 'none'; // テキスト非表示
            };

            reader.readAsDataURL(file);
        }
    </script>

</div>

@endsection