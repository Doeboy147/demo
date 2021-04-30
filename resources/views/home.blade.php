@extends('layouts.app')

@section('content')
    <div class="col-md-12 mb-5">
        <h3>Welcome back <span class="text-danger"> {{ $user->name }}</span></h3>
    </div>
    <div class="col-md-12 mb-5">
        <button class="btn btn-primary shadow" data-toggle="modal" data-target="#add-post">
            <i class="fa fa-upload"></i>
            Add Post
        </button>
        <a class="btn btn-secondary shadow" href="/"><i class="fa fa-home"></i> View Posts</a>
        @include('posts.create')
    </div>
    <div class="col-md-12 mt-5">
        <div class="card shadow-sm">
            <div class="card-header pt-4 pb-4">{{ __('Dashboard') }}</div>

            <div class="card-body table-responsive">
                @if($posts->count() > 0)
                    <table class="table table-bordered">
                        <thead>
                        <tr class="table-active">
                            <th>Image</th>
                            <th>Title</th>
                            <th>Body</th>
                            <th>Date added</th>
                            <th>Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>
                                    <img width="45" class="img-thumbnail" src="{{ $post->getImage() }}">
                                </td>
                                <td> {{ $post->title }}</td>
                                <td> {{ Str::limit($post->body, 40)  }}</td>
                                <td> {{ $post->created_at->format('d D M Y H:s') }}</td>
                                <td class="text-right">
                                    @if(Auth::user()->uuid === $post->user_id)
                                        <a class="btn btn-secondary"
                                           href="{{ route('show-post', ['id' => $post->uuid]) }}">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>
                                    @else
                                        <button disabled class="btn btn-secondary"><i class="fa fa-lock"></i> Edit
                                        </button>
                                    @endif

                                    @if(Auth::user()->uuid === $post->user_id)
                                        <a class="btn btn-danger delete"
                                           href="{{ route('delete-post', ['id' => $post->uuid]) }}">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    @else
                                        <button disabled class="btn btn-danger"><i class="fa fa-lock"></i> Delete
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h4 class="text-center text-danger">There's currently no posts</h4>
                @endif
            </div>
        </div>
    </div>
@endsection
