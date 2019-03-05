@extends('layout')
@section('title', 'Add new job')
@section('description', '')
@section('header')
    @include('header')
@endsection
@section('content')
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-8">
                {!! $errors->first() !!}
                <form method="post" action="{{ action('IndexController@insertJobSave') }}" accept-charset="UTF-8">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Domain</label>
                        <input type="text" class="form-control" name="domain" value="{{ old('domain') }}" placeholder="Enter domain ex: shopee.vn">
                        <small class="form-text text-muted">This domain for affiliate ex: shopee.vn</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
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