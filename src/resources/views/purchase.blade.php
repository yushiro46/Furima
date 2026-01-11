@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase-container">

    <!-- 左側 -->
    <div class="purchase-left">

        <!-- 商品情報 -->
        <div class="item-box">
            <img src="{{ asset('storage/products/' . $item->image) }}" alt="商品画像" class="item-image">

            <div class="item-info">
                <p class="item-name">{{ $item->name }}</p>
                <p class="item-price">¥{{ number_format($item->price) }}</p>
            </div>
        </div>

        <hr class="separator">

        <form action="/purchase/{{ $item->id }}/pay" method="post">
            @csrf
            <!-- 支払い方法 -->
            <div class="section">
                <h3 class="section-title">支払い方法</h3>
                <select name="payment" class="payment-select" required>
                    <option value="" selected hidden>選択してください</option>
                    <option value="コンビニ支払い">コンビニ支払い</option>
                    <option value="カード支払い">カード支払い</option>
                </select>
            </div>

            <hr class="separator">

            <!-- 配送先 -->
            <div class="section">
                <h3 class="section-title">配送先</h3>

                <div class="address-box">
                    <p>〒{{ substr($user->postal_code, 0,3) }}-{{ substr($user->postal_code, 3) }}</p>
                    <p>{{ $user->address }}</p>
                    <p>{{ $user->building }}</p>
                </div>

                <input type="hidden" name="shipping_address" value="{{ $user->postal_code }} {{ $user->address }} {{ $user->building }}">

                <div class="form__error">
                    @error('shipping_address')
                    {{ $message }}
                    @enderror
                </div>

                <a href="/purchase/address/{{ $item->id }}" class="address-edit-btn">変更する</a>

            </div>

            <hr class="separator">

    </div>


    <!-- 右側 -->
    <div class="purchase-right">

        <div class="summary-box">

            <div class="summary-row">
                <p class="summary-title">商品代金</p>
                <p class="summary-value">¥{{ number_format($item->price) }}</p>
            </div>

            <div class="summary-row">
                <p class="summary-title">支払い方法</p>
                <p class="summary-value selected-payment">未選択</p>
            </div>

            <div class="form__error">
                @error('payment')
                {{ $message }}
                @enderror
            </div>

            <button type="submit" class="buy-btn">購入する</button>
            </form>
        </div>

        @if (session('error'))
        <div class="form__error">
            {{ session('error') }}
        </div>
        @endif


    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.querySelector('.payment-select');
        const display = document.querySelector('.selected-payment');

        select.addEventListener('change', function() {
            display.textContent = select.value || "未選択";
        });
    });
</script>

@endsection