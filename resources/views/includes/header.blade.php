<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{$title}}</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css" integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{url('siteassets/css/custom.css')}}" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{url('/')}}">My Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link {{ (Request::is('/') ? 'active' : '') }}" href="{{url('/')}}">Home</a></li>
                    @auth
                    <li class="nav-item"><a class="nav-link {{ (Request::is('my-posts') ? 'active' : '') }}" aria-current="page" href="{{url('my-posts')}}">My Posts</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('logout')}}">Logout</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('my-posts')}}">
                            @inject('central', 'App\CentralLogics\Uservalidation')
                            {!!$central->user_icon(Auth::user()->id)!!}
                        </a></li>

                    @else
                    <li class="nav-item"><a class="nav-link {{ (Request::is('register') ? 'active' : '') }}" href="{{url('register')}}">Register</a></li>
                    <li class="nav-item"><a class="nav-link {{ (Request::is('login') ? 'active' : '') }}" href="{{url('login')}}">Login</a></li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    <!-- Page header with logo and tagline-->
    <header class="py-5  border-bottom mb-4">
        <div class="container">
            <div class="text-center my-5">
                <h1 class="fw-bolder">{{$title}}</h1>
                <!-- <p class="lead mb-0">A Bootstrap 5 starter layout for your next blog homepage</p> -->
            </div>
        </div>
    </header>
    <!-- Page content-->
    <div class="container">