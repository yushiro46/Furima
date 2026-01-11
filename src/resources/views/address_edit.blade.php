@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address_edit.css') }}">
@endsection

@section('content')
<div class="address-edit-container">

    <h2 class="title">住所の変更</h2>

    <form action="/address/update/{{ $item->id }}" method="post" class="address-form">
        @csrf

        <label class="form-label">郵便番号</label>
        <input type="text" name="postal_code" class="form-input input-postal" value="{{ substr($user->postal_code, 0,3) . '-' . substr($user->postal_code, 3) }}">

        <div class="form__error">
            @error('postal_code')
            {{ $message }}
            @enderror
        </div>

        <label class="form-label">住所</label>
        <input type="text" name="address" class="form-input input-address" value="{{ old('address', $user->address) }}">

        <div class="form__error">
            @error('address')
            {{ $message }}
            @enderror
        </div>

        <label class="form-label">建物名（任意）</label>
        <input type="text" name="building" class="form-input input-building" value="{{ old('building', $user->building) }}">

        <button type="submit" class="update-btn">更新する</button>
    </form>

</div>
@endsection