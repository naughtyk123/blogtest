@extends('includes.default')
@section('content')

<div class="row">
    <!-- Blog entries-->
    <div class="col-lg-8">
        @auth
        <div class="col-lg-12 mb-4">
            <a  type="button" href="{{url('add-post')}}" class="btn btn-success" value="Add Post">Add Post</a>
        </div>
        @endauth
        <div class="search_results">
            @include('frontend.post_card')
        </div>
    </div>
    <!-- Side widgets-->
    <div class="col-lg-4">
        <!-- Search widget-->
        <div class="card mb-4">
            <div class="card-header">Search</div>
            <div class="card-body">
                <div class="card mb-4">
                    <div class="card-header">Categories</div>
                    <div class="card-body">
                        <div class="row">


                            @foreach($categories as $cat)
                            <div class="col-sm-4 mb-2">
                                <a id="cat_select{{$cat->id}}" onclick="catselect('{{$cat->id}}')" class=" catbtn btn btn-primary  form-control">{{$cat->category_name}}</a>
                            </div>
                            @endforeach
                            <div class="col-sm-4 mb-2">
                                <a id="cat_select0" onclick="catselect(0)" class=" catbtn btn btn-primary  form-control">All</a>
                            </div>
                            <input type="hidden" id="catinput">

                        </div>
                    </div>
                </div>
                <div class="input-group">
                    <input class="form-control" onkeyup="search()" id="key" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                    <button class="btn btn-primary" onclick="search()" id="button-search" type="button">Go!</button>
                </div>
            </div>
        </div>
        <!-- Categories widget-->


    </div>
</div>

@stop
@section('script')

<script>
    function catselect(id) {
        $('.catbtn').css('background', '#0d6efd');
        $('#cat_select' + id).css('background', 'red');
        $('#catinput').val(id);
        search();
    }

    $(document).on('click', '.search_results .page-link', function(e) {

        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1]
        record(page);
    });

    function record(page) {
        $.ajax({
            url: "/get_search_result?page=" + page,
            data: {
                "_token": "{{ csrf_token() }}",
                "key": $('#key').val(),
                'cat': $('#catinput').val()
            },
            beforeSend: function() {},
            success: function(data) {
                $('.search_results').html('');
                $('.search_results').html(data);
            }
        })
    }

    function search() {
        $.ajax({
            type: 'GET',
            url: '/get_search_result',
            data: {
                "_token": "{{ csrf_token() }}",
                "key": $('#key').val(),
                'cat': $('#catinput').val()
            },
            beforeSend: function() {},
            success: function(data) {
                $('.search_results').html('');
                $('.search_results').html(data);
            }
        });
    }
</script>

@stop
