@extends('layout')
@section('title', 'Danh sách sản phẩm')
@section('header')
    @include('header')
@endsection
@section('content')
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-8">
                <div class="form-group mt-2">
                    <div class="alert alert-info p-2">
                        <strong>Cung Cấp đến mọi người ⭐ ⭐ ⭐ ⭐ ⭐</strong>
                        <p>Đăng tin lên Cung Cấp để cung cấp sản phẩm, dịch vụ kinh doanh đến mọi người hoàn toàn miễn phí! </p>
                    </div>
                    <div class="btn-group d-flex" role="group"><a class="btn btn-success w-100" href="https://cungcap.net" target="_blank"><h4>Đăng tin miễn phí</h4></a></div>
                </div>
                @if(count($listProduct)>0)
                    <ul class="list-group">
                        <?php $i=0; ?>
                        @foreach($listProduct as $item)
                            <?php $i++;?>
                            @if($i==3 || $i==9)

                            @endif
                            <li class="list-group-item">
                                <h3><a href="{!! route('view.product',array($item->id,str_slug($item->title))) !!}">{!! $item->title !!}</a></h3>
                            </li>
                        @endforeach
                    </ul>
                    <div class="form-group mt-2">
                        {{ $listProduct->links() }}
                    </div>
                @endif
            </div>
            <div class="col-md-4">
            </div>

        </div>
    </div>
@endsection
@section('css')
@endsection
@section('script')
@endsection