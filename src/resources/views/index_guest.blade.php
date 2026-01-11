@extends('layouts.guest')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="toppage-list">
    <a
        href="{{ route('items.index', ['tab' => 'recommend']) }}"
        class="tab-btn {{ request('tab') !== 'mylist' ? 'active' : '' }}">
        おすすめ
    </a>

    @auth
    <a
        href="{{ route('items.index', ['tab' => 'mylist']) }}"
        class="tab-btn {{ request('tab') === 'mylist' ? 'active' : '' }}">
        マイリスト
    </a>
    @else
    <a href="{{ route('login') }}" class="tab-btn">マイリスト</a>
    @endauth
</div>

<div class="item-list">
    @foreach ($items as $item)
    <div class="item-card">
        <a href="/item/{{ $item->id }}" class="item-card__link">
            <div class="item-card__image-wrapper">
                <img src="{{ asset('storage/products/' . $item->image) }}" alt="{{ $item->name }}" class="item-card__image">

                @if ($item->isSold())
                <span class="sold-badge">Sold</span>
                @endif
            </div>
        </a>
        <div class="item-card__name">
            {{ $item->name }}
        </div>
    </div>
    @endforeach
</div>

<div class="pagination">
    {{ $items->links('pagination::default') }}
</div>


@endsection