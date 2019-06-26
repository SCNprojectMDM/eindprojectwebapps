@extends('layouts.app')

@section('content')

    <div class="jumbotron text-center">
        <h1 class="display-4">Hallo!</h1>
        <h4>Dit is mijn eindopdracht voor het vak WebApps. Dit is een blog waar je een account kan aanmaken en berichten met een foto kan plaatsen.</h4>

        @guest
            <h4 class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </h4>
            @if (Route::has('register'))
                <h4 class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </h4>
            @endif
        @else
            <br  />
            <div>

                <h3>Welkom, {{ Auth::user()->name }}!</h3>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="/posts/create" role="button">Maak eeen bericht aan!</a>
                </p>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a href="posts/create" class="dropdown-item">Create Post</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>`
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest

    </div>
@endsection
