<div class="row ">
    @foreach($posts as $post)
    <div class="col-md-6">
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
                <p class="card-text">
                    @inject('central', 'App\CentralLogics\Uservalidation')
                    {!!$central->user_icon($post->user_id)!!}
                </p>
                <a class="btn btn-primary mb-4" href="{{url('reade-more')}}/{{$post->id}}">Read more →</a>
                @auth
                @if($post->user_id==Auth::user()->id)
                <a class="btn btn-warning mb-4" href="{{url('edite')}}/{{$post->id}}">Edite</a>
                <a class="btn btn-danger mb-4" onclick="delete_post('{{$post->id}}')">Delete</a>
                @endif
                @endauth
            </div>
        </div>
    </div>
    @endforeach

    {{ $posts->links() }}



</div>