<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="viewport" content="initial-scale=1.0">

    <title>{{ env('APP_NAME') }}</title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
    {{-- google font --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    @yield('css')
</head>

<body class="hold-transition skin-purple layout-top-nav">
    <div class="wrapper">
        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="/" class="navbar-brand">{{ env('APP_NAME') }}</a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="{{(Request::segment(1) == '/' || Request::segment(1) == '') ? "active" : ""}}">
                                <a href="/">
                                    <i class="fa fa-home"></i>
                                    Home
                                </a>
                            </li>
                        </ul>
                        <form class="navbar-form navbar-left" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" id="navbar-search-input"
                                    placeholder="Pencarian">
                            </div>
                        </form>
                    </div>

                    @if( !Auth::user() )
                    <div class="collapse navbar-collapse pull-right" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Masuk</a></li>
                        </ul>
                    </div>
                    @else
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="{{ asset('images/avatar_default.png') }}" class="user-image"
                                        alt="User Image">
                                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <img src="{{ asset('images/avatar_default.png') }}" class="img-circle"
                                            alt="User Image">

                                        <p>
                                            {{ Auth::user()->name }}
                                            <small>
                                                Member
                                                Sejak {{ date_format(Auth::user()->created_at, 'M. Y') }}
                                            </small>
                                        </p>
                                    </li>

                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Sign out
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                @endif
            </nav>
        </header>
        <div class="content-wrapper">
            <div class="container">
                <section class="content-header">
                    @yield('header')
                </section>

                <section class="content">
                    @yield('content')
                </section>

            </div>

        </div>

        <footer class="main-footer">
            <div class="container">
                <strong>Copyright &copy; 2019 <a href="#">{{ env('APP_NAME') }}</a>.</strong> All rights reserved.
            </div>
        </footer>
    </div>
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('/js/jquery.toast.min.js') }}"></script>

    @yield('js')
</body>

</html>
