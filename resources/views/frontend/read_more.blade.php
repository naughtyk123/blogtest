@extends('includes.default')
@section('content')
<style>
    .relatediv .col-md-6{
        width:100%!important;
    }
</style>
<div class="row">

    <div class="col-md-8">
        <h1>{{$post->title}}</h1>
        <p>By : {{$post->user->name}}</p>
        <p>On : {{$post->created_at}}</p>

        <div class="card   mb-4">

            <div class="card_image_div">
                @if($post->images)

                <a href="#!"><img class="card-img-top" src="{{url($post->images->path)}}" onerror="this.onerror=null;this.src='{{url('siteassets/img/noimage.jpg')}}';" /></a>
                @else
                <a href="#!"><img class="card-img-top" src="{{url('siteassets/img/noimage.jpg')}}" /></a>

                @endif
            </div>
            <div class="card-body">
                <input type="button" style="float:right" class="btn btn-info" value="{{$post->category->category_name}}">

                <div class="small text-muted">{{ $post->created_at->diffForHumans() }}</div>
                <h2 class="card-title h4">{{$post->title}}</h2>
                <p class="card-text">{!!$post->post!!}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4 relatediv">
        <h1>Related</h1>
    
       
        @include('frontend.post_card')
     


    </div>



</div>

@stop
@section('script')


@stop
