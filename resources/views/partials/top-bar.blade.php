<div class="ui menu">
    <a class="header item" href="{{ route('home') }}">
        <img class="ui image" src="{{ asset('img/mirage-logo.png') }}" height="30">
    </a>
    @if(auth()->check())
        <a class="item" href="{{ route('product.index') }}">Products</a>
        <a class="item" href="{{ route('user.index') }}">Users</a>
        <a class="item" href="{{ route('notification.index') }}">Push Notification</a>
    @endif
    <div class="right menu">
        @if(auth()->check())
            <div class="item">Logged as: &nbsp; <b>{{ auth()->user()->username }}</b></div>
            <a class="item" href="{{ route('logout') }}">Logout</a>
        @else
            <a class="item primary" href="{{ route('login') }}">Login</a>
        @endif
    </div>
</div>