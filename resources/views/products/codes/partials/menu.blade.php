<div class="ui small menu">
    <div class="right menu">

        <a class="item" href="{{ route('product.index') }}">
            <i class="list icon"></i>
            All Products
        </a>
        <a class="item" href="{{ route('product.code.export', $product) }}">
            <i class="download icon"></i>
            Export All
        </a>
        <a class="item" href="{{ route('product.code.create', $product) }}">
            <i class="add icon"></i>
            Generate More Codes
        </a>

    </div>

</div>