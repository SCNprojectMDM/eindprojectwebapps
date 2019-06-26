@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-default btn-secondary float-left"> Ga Terug </a>
    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)

             <a href="/posts/{{$post->id}}/edit" class="btn btn-success float-right" style="margin-left: 5px;"> Edit </a>

            {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right']) !!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete', ['class' => 'btn btn-danger float-right'])}}
            {!! Form::close() !!}
        @endif
    @endif
    <br  />
    <br  />
    <hr  />

    <div class="row">
        <div class="col-sm-7">
            <h1>{{$post->title}}</h1>
            {!!$post->body!!}
        </div>
        <div class="col-sm-5">
            <img style="width: 100%;" src="/storage/cover_images/{{$post->cover_image}}">
            <small>Written on {{$post->created_at}}</small>
        </div>
    </div>
    <div>

    </div>
    <hr>

@endsection
