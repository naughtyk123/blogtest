@extends('includes.default')
@section('content')

<div class="row">
    <!-- Blog entries-->
    <div class="col-lg-12">
        @auth
        <div class="col-lg-12 mb-4">
            <a style="float:right" type="button" href="{{url('add-post')}}" class="btn btn-success" value="Add Post">Add Post</a>
        </div>
        @endauth
        @include('frontend.post_card')
    </div>

</div>

@stop
@section('script')


@stop