@extends('layout')
@section('title', $product->title)
@section('description', $product->description)
@section('header')
    @include('header')
@endsection
@section('content')
    @if($product->ads=='active')
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-6739685874678212",
                enable_page_level_ads: true
            });
        </script>
    @endif
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-8">
                <h1>{!! $product->title !!}</h1>
                <small>Updated at: {!! $product->updated_at !!}</small>
                <div class="form-group mt-2">
                    <div class="alert alert-info p-2">
                        <strong>Cung Cấp đến mọi người ⭐ ⭐ ⭐ ⭐ ⭐</strong>
                        <p>Đăng tin lên Cung Cấp để cung cấp sản phẩm, dịch vụ kinh doanh đến mọi người hoàn toàn miễn phí! </p>
                    </div>
                    <div class="btn-group d-flex" role="group"><a class="btn btn-success w-100" href="https://cungcap.net" target="_blank"><h4>Đăng tin miễn phí</h4></a></div>
                </div>
                <div class="form-group mt-2">
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-6739685874678212"
                         data-ad-slot="7536384219"
                         data-ad-format="auto"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
                @if(!empty($product->img_thumb))
                    <div class="form-group mt-2 text-center">
                        <img class="img-fluid" src="{!! $product->img_thumb !!}">
                    </div>
                @endif
                <div class="form-group mt-2">
                    <p>Tên sản phẩm: <strong>{!! $product->title !!}</strong></p>
                    <p><strong>ID sản phẩm: </strong>{!! $product->product_id !!}</p>
                    <p><strong>Mô tả sản phẩm: </strong>{!! $product->description !!}</p>
                    <p><strong>Danh mục: </strong>{!! $product->category !!}</p>
                    <p><strong>Mã sản phẩm: </strong>{!! $product->sku !!}</p>
                    <p><strong>Giá bán: </strong>{!! $product->price !!}</p>
                    <p><strong>Giá giảm: </strong>{!! $product->discount !!}</p>
                    <p><strong>URL: </strong>{!! $product->url !!}</p>
                    <p><strong>Cung cấp bởi: </strong>{!! $product->domain !!}</p>
                </div>
            </div>
            <div class="col-md-4">
                <h4>List new product</h4>
                <div class="form-group mt-2">
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-6739685874678212"
                         data-ad-slot="7536384219"
                         data-ad-format="auto"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
                @if(count($listNew)>0)
                    <ul class="list-group">
                        @foreach($listNew as $item)
                            @if(!empty($item->title))
                            <li class="list-group-item">
                                <h3><a href="{!! route('view.product',array($item->id,str_slug($item->title))) !!}">{!! $item->title !!}</a></h3>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('css')
@endsection
@section('script')
@endsection