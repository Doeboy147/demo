@extends('layouts.app')
@section('content')
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header pt-3 pb-3"><strong>Edit post </strong>  - {{ $post->title }}</div>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-thumbnail img-fluid" width="200" src="{{ $post->getImage() }}">
                </div>
                <form class="async" action="{{ route('update-post', ['id' => $post->uuid]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input type="text" value="{{ $post->title }}" name="title" placeholder="Post title" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" onfocus="this.type='file'" name="imageFile" placeholder="Image" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <textarea name="body" rows="7" placeholder="Post body" class="form-control">{{ $post->body }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('home') }}" class="btn btn-secondary" data-dismiss="modal">Go Back</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop