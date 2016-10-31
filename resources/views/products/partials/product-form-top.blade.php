<div class="ui top attached tabular menu">
    <div class="header item">
        Name & Description
    </div>
    <div class="right menu">
        <a class="item active" data-tab="name_en">English</a>
        <a class="item" data-tab="name_zh">Chinese</a>
        <a class="item" data-tab="name_zh_tw">Simplified Chinese</a>
        <a class="item" data-tab="name_ja">Japanese</a>
    </div>
</div>

{{--*/ $nameArray = @$product?$product->nameArray:array()  /*--}}
{{--*/ $descriptionArray = @$product?$product->profile->descriptionArray:array()  /*--}}
{{--*/ $language = ['en' => '', 'zh' => 'Chinese ', 'zh_tw' => 'Simplified Chinese ', 'ja' => 'Japanese '] /*--}}
{{ dd($product->profile->descriptionArray) }}
@foreach($language as $lang => $placeHolder)
    <div class="ui bottom attached segment tab {{ ($lang=='en'?'active':'') }}" data-tab="name_{{ $lang }}">
        <input type="text" name="name[{{ $lang }}]" placeholder="{{ $placeHolder }}Name" value="{{ old('name['.$lang.']', @$nameArray[$lang]) }}">
        <br/><br/>
                <textarea type="text" name="description[{{ $lang }}]" placeholder="{{ $placeHolder }}Description"
                          rows="2">{{ old('description['.$lang.']', @$descriptionArray[$lang]) }}</textarea>
    </div>
@endforeach
