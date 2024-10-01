{{-- Header Section --}}
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Blood Donation Backend</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        @yield('head')
        <!-- Google fonts-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
        <link href="/style.css" rel="stylesheet">
    </head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
        <div class="bg-dark col-3 col-md-2 min-vh-100">
            <div class="side">
            <div class="bg-dark p-2 mt-3">
                <a class="d-flex text-decoration-none mt-2 align-items-center">
                    <span class="fs-4 d-none d-sm-inline text-white mx-4">Admin Panel</span>
                </a>
                <ul class="nav nav-pills flex-column mt-4">
                    <li class="nav-item">
                        <a href="{{route('backend.dashboard')}}" class="nav-link text-white"><i class="fa-solid fa-gauge mx-2"></i><span class="d-none d-md-inline">Dashboard</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('backend.bloodcamps')}}" class="nav-link text-white"><i class="fa-regular fa-hospital mx-1"></i> <span class="d-none d-md-inline">Blood Camps</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('backend.bloodreq')}}" class="nav-link text-white"><i class="fa-solid fa-droplet mx-2"></i> <span class="d-none d-md-inline">Blood Requests</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('backend.webuser')}}" class="nav-link text-white"><i class="fa-solid fa-users mx-1"></i> <span class="d-none d-md-inline">Web-Users</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('backend.admin')}}" class="nav-link text-white"><i class="fa-solid fa-user mx-2"></i> <span class="d-none d-md-inline">Admin</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('backend.roles')}}" class="nav-link text-white"><i class="fa-solid fa-screwdriver-wrench mx-2"></i> <span class="d-none d-md-inline">Roles</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('backend.permissions')}}" class="nav-link text-white"><i class="fa-brands fa-black-tie mx-2"></i> <span class="d-none d-md-inline">Permissions</span></a>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link">
                        <form action="{{ route('backend.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-white" style="background: none; border: none;">
                                <i class="fa-solid fa-power-off mx-1"></i> <span class="d-none d-md-inline">Logout</span>
                            </button>
                        </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        </div>
        {{-- Body Section --}}
        <div class="col-9 col-sm-10">
        @yield('body')
        </div>
        </div>
    </div>
</body>

{{-- Footer Section --}}

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- JQuery script-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
@yield('scripts')
</html>
