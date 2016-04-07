<div class="ui small menu">
    <div class="right menu">
        <a class="item" href="{{ route('user.index') }}">
            <i class="list icon"></i>
            All Users
        </a>
        <a class="item" href="{{ route('user.edit', $user->id) }}">
            <i class="edit icon"></i>
            Edit User
        </a>
        <a class="item" href="{{ route('user.add.code', $user->id) }}">
            <i class="add icon"></i>
            Add Code
        </a>
    </div>

</div>