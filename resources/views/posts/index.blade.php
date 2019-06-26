@extends('layouts.app')

@section('content')

    <h1 class="text-center">Alle Posts</h1>
    <hr  />
    <div class="container">
        <div class="row">
    @if(count($posts) > 0)

        @foreach($posts as $post)
                <a href="/posts/{{$post->id}}">
                        <div class="col-md-4">
                            <div class="card mb-4 box-shadow">
                                <img style="width: 100%;" src="/storage/cover_images/{{$post->cover_image}}">
                                <div class="card-body">
                                    <h3 class="blogtitle"><a href="/posts/{{$post->id}}">{{$post->title}}</h3>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="blogcoverinfo">Written on {{$post->created_at}} by {{$post->user->name}}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                </a>


        @endforeach
        {{$posts->links()}}
    @else
        <p>NOH MAN</p>
    @endif
        </div>
    </div>
@endsection
