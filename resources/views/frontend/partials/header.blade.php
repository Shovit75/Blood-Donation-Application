<!doctype html>
<html lang="en">
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Blood Donation Frontend</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        @yield('head')
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
        <link href="{{asset('frontendstyle.css')}}" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <!-- Navigation-->
        {{-- style="background-color: rgba(0, 0, 0, 0.05);" --}}
        <nav class="navbar navbar-expand-md navbar-light">
            <div class="container-lg px-3">
                <h1 class="navbar-brand mt-3"><a href="{{route('frontend.index')}}" class="logo">Blood.Sikkim.Co</a></h1>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse mt-3" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto py-0">
                        <li class="nav-item">
                            <div class="nav-link px-md-2 px-lg-3 py-3 py-lg-3">
                                <form action="{{route('frontend.search')}}" class="form-inline">
                                    <div class="input-group">
                                        <input class="form-control" name="search" type="search" placeholder="Search here..." aria-label="Search">
                                        <button class="btn btn-outline-info" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link px-md-3 px-lg-3 py-3 py-lg-4" href="{{route('frontend.about')}}" style="color: #36454F">About</a></li>
                        <li class="nav-item"><a class="nav-link px-md-3 px-lg-3 py-3 py-lg-4" href="{{route('frontend.activereq')}}" style="color:#36454F">Active Requirements</a></li>
                        <li class="nav-item"><a class="nav-link px-md-3 px-lg-3 py-3 py-lg-4" href="{{route('frontend.bdcamps')}}" style="color:#36454F">Blood Donation Camps</a></li>
                        <li class="nav-item">
                            @if (Auth::guard('webuser')->check())
                                <a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('frontend.webuserprofile')}}"><p class="primarycolor">{{Auth::guard('webuser')->user()->name}}</p></a>
                            @else
                                <a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('frontend.webuserlogin')}}"><p class="primarycolor">Login / SignUp</p></a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
