<div class="ui fluid menu">

    @if(!auth()->check())
        <a href="{{ route('web.login') }}" class="item">
            Login
        </a>
        <a href="{{ route('web.register') }}" class="item">
            Register
        </a>
    @else
        <a href="{{ route('web.product.register') }}" class="item">
            Register Product
        </a>
        <div class="right menu">
            <div class="item">Logged as: &nbsp; <b>{{ auth()->user()->username }}</b></div>
            <a class="item" href="{{ route('logout') }}">Logout</a>
        </div>
    @endif

</div>

