@extends('layouts.app')
@section('content')
    <div class="col-md-12 mt-4 mb-5">
        <h1 class="text-center text-muted"> Demo Blog</h1>
    </div>
    <div class="col-md-8 mt-5">
        <div class="card shadow-sm">
            <div class="card-header pt-4 pb-4"> Latest posts</div>
            <div class="card-body">
                @if($posts->count() > 0)
                    @foreach($posts as $post)
                        <div class="card mt-5">
                            <div class="row m-3 no-gutters">
                                <div class="col-md-2">
                                    <img width="200" src="{{ $post->getImage() }}" class="img-thumbnail"
                                         alt="{{ $post->title }}">
                                </div>
                                <div class="col-md-10">
                                    <strong class="float-right"><i class="fa fa-heart text-danger"></i> {{ $post->likes->count() }} | <i class="fa fa-user"> </i><span class="text-muted"> {{ $post->user->name }}</span>  | <i class="fa fa-calendar text-success"></i> <span
                                                class="text-muted"> {{ $post->created_at->format('d D M Y H:s') }}</span>
                                    </strong>
                                    <a href="{{ route('read-post', ['id' => $post->id]) }}"><h4 class="mb-3 pl-3 pr-3"> {{ $post->title }}</h4></a>
                                    <p class="m-auto p-3">
                                        {{ $post->body }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h3 class="text-center text-danger"> There's currently no posts</h3>
                @endif
            </div>
            <div class="card-footer">
                {{ $posts->appends($_GET)->links() }}
            </div>
        </div>
    </div>
    <div class="col-md-4 mt-5">
        <div class="card shadow-sm">
            <div class="card-header pt-4 pb-4"> Search</div>
            <div class="card-body">
                <form action="" method="get">
                    <input type="text" placeholder="Search here..." name="search" class="form-control">
                    <button type="submit" class="btn btn-secondary mt-3"> Search</button>
                </form>

                <h3 class="text-muted border-top pt-2 mt-5 mb-2"> Available posts</h3>

                <h1>
                    {{ $posts->total() }}
                </h1>
            </div>
        </div>
    </div>
@stop