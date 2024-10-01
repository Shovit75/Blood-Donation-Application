<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
<div style="padding-top:100px"></div>
<div id="main-wrapper" class="container bodylogin mt-5">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="row no-gutters">
                        @if ($errors->any())
                                <div class="mb-4">
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <div class="text-center">{{ $error }}</div>
                                    @endforeach
                                </div>
                                </div>
                                @endif
                        <div class="card mb-5">
                            <div class="p-3">
                                <div class="mb-4">
                                    <h3 class="font-weight-bold text-danger text-center mt-3">Reset Password Page</h3>
                                </div>
                                @if(session('message'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('message') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <p class="text-muted mt-2 mb-4 text-center">Enter your new password to change.</p>
                                <form action="{{ route('frontend.resetpassforgotstore') }}" method="POST" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email Address" value="{{ request()->get('email') }}" required readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password">Enter New Password</label>
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required>
                                    </div>
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                    <br><br>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
