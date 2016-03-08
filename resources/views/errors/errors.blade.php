@if($errors->any())

    <div class="ui error message">
        <i class="close icon"></i>
        <div class="header">
            Ooooops
        </div>
        <ul class="list">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>

@endif

@if(session()->has('success'))

    <div class="ui success message">
        <i class="close icon"></i>
        <div class="header">
            Success
        </div>
        <p>{{ session()->get('success') }}</p>
    </div>

@endif