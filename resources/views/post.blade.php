@extends('layouts.app')
@section('content')
    <div class="col-md-12 mt-4 mb-5">
        <h1 class="text-center text-muted"> Demo Media Blog</h1>

    </div>
    <div class="col-md-10 mt-5">
        <a class="btn btn-secondary mb-3" href="/"><i class="fa fa-arrow-left"></i> Go Back</a>
        <div class="card shadow-sm">
            <div class="card-header pt-4 pb-4"> {{ $post->title }}
                    <a href="{{ route('like-post', ['id' => $post->uuid]) }}"
                       class="badge badge-danger float-right async"><i class="fa fa-heart fa-2x"></i> </a>
            </div>
            <div class="card-body">
                <div class="card mt-5">
                    <div class="row m-3 no-gutters">
                        <div class="col-md-2">
                            <img width="200" src="{{ $post->getImage() }}" class="card-img-top"
                                 alt="{{ $post->title }}">
                        </div>
                        <div class="col-md-10">
                            <strong class="float-right">  <i class="fa fa-heart text-danger"></i> {{ $post->likes->count() }} | <i class="fa fa-user"></i> <span class="text-muted">{{ $post->user->name }}</span> | <i
                                        class="fa fa-calendar text-success"></i> <span
                                        class="text-muted"> {{ $post->created_at->format('d D M Y H:s') }}</span>
                            </strong>
                            <a href="{{ route('read-post', ['id' => $post->id]) }}"><h4
                                        class="mb-3 pl-3 pr-3"> {{ $post->title }}</h4></a>
                            <p class="m-auto p-3">
                                {{ $post->body }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @if(empty(Auth::user())===false && Auth::user()->uuid === $post->user_id)
                <div class="card-footer text-right">
                    <a class="btn btn-secondary" href="{{ route('show-post', ['id' => $post->uuid]) }}">
                        <i class="fa fa-pencil"></i> Edit
                    </a>
                    <a class="btn btn-danger delete" href="{{ route('delete-post', ['id' => $post->uuid]) }}">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
            @endif
        </div>
    </div>
@stop