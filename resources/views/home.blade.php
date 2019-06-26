@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Berichten</div>

                <div class="card-body">
                    <h3 class="text-center">Alle Eigen berichten</h3>
                    @if(count($posts) > 0)
                    <table class="table table-striped">

                        <tr>
                            <th>Title</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{$post->title}}</td>
                                <td><a href="/posts/{{$post->id}}/edit" class="btn btn-success">Edit</a></td>
                                <td>
                                    {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right']) !!}
                                    {{Form::hidden('_method', 'DELETE')}}
                                    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </table>
                    @else
                        <p>Je hebt nog geen berihten geplaatst!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
