@extends('frontend.partials.body')

@section('body')
<div id="main-wrapper" class="container bodylogin mt-5">
    <div class="pt-4"></div>
    <div class="row justify-content-center">
        <div class="col-xl-10 mb-3">
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
                            <div class="d-none d-md-block" style="padding-top: 60px"></div>
                            <div class="col-lg-6">
                            <div class="px-5">
                                <div class="my-2">
                                    <h3 class="primarycolor fw-bold">Login Page</h3>
                                </div>
                                @if(session('message'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('message') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <p class="mt-2 mb-2">Enter your login credentials</p>
                                <form action="{{route('frontend.webusersignin')}}" method="POST" novalidate>
                                    @csrf
                                    <div class="form-group mt-4">
                                        <label class="charcoal" for="email">Email address</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email Address" required>
                                    </div>
                                    <div class="form-group mt-2 mb-3">
                                        <label class="charcoal" for="password">Password</label>
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required>
                                    </div>
                                    <button type="submit" class="btn btn-info text-white">Login</button>
                                    <br><br> or
                                    <a href="#" class="forgot-link float-right text-info" onclick="$('#phoneModal').modal('show')">Sign in with Mobile</a>
                                    <br><br>
                                    <a href="#" class="forgot-link float-right charcoal" onclick="$('#forgotModal').modal('show')">Forgot password?</a>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 d-none d-lg-inline-block">
                            <img src="{{ asset('login.jpg') }}" alt="image" class="img-fluid">
                        </div>
                        <div class="d-none d-md-block" style="padding-top: 70px"></div>
                    </div>
                </div>
            </div>
            <p class="text-muted text-center my-5">Don't have an account? <a href="#" class="ml-1 primarycolor" onclick="$('#registerModal').modal('show')">Register</a></p>
        </div>
    </div>
</div>

 {{-- New User Add --}}
 <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registerModalLabel">Register a New User</h5>
          <button type="button" class="btn close" style="color: red;" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
        <div class="modal-body">
        <form id="enterinvalid" action="{{route('frontend.webusersignup')}}" method="POST" novalidate>
            @csrf
            <div class="form-group py-2">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Example">
            </div>
            <div class="form-group py-2">
                <label for="emailreg">Email</label>
                <input type="email" id="emailreg" name="email" class="form-control" placeholder="Example@gmail.com">
            </div>
            <div class="row">
                <div class="col-8 col-md-9">
                    <div class="form-group py-2">
                        <label for="phone">Contact</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+91</span>
                            </div>
                            <input type="tel" name="phone" id="phonenumber" placeholder="9832******" class="form-control" maxlength="10">
                        </div>
                    </div>
                </div>
                <div class="col-3 col-md-3">
                    <div class="form-group pt-4">
                        <div id="sendsms" class="btn btn-info text-white my-2">Verify</div>
                    </div>
                </div>
                <div id="alertshow" class="form-group text-danger" style="display: none;">
                    <span>Enter a valid number.</span>
                </div>
                <div id="alreadyexists" class="form-group text-danger" style="display: none;">
                    <span>Number already exists or invalid number.</span>
                </div>
            </div>
            <div class="form-group py-2">
                <label for="passwordreg"> Password</label>
                <input type="password" name="password" id="passwordreg" class="form-control" placeholder="Minimum 8 characters">
            </div>
            <hr>
            <div id="closeonverified" class="form-group py-2 text-danger text-center">
                <span>Verify the Contact Number first.</span>
            </div>
            <div id="notdisplayable" style="display:none;">
                <div class="form-group py-1">
                    <label for="code"> Verification Code </label>
                    <input type="number" name="code" id="code" class="form-control" placeholder="Enter OTP">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-info text-white my-2">Create User</button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

 {{-- Forget Password --}}
 <div class="modal fade" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="forgotModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="forgotModalLabel">Forgot Password</h5>
          <button type="button" class="btn close" style="color: red;" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{route('frontend.forgotpass')}}" method="POST" novalidate>
            @csrf
            <div class="form-group py-2">
                <label for="emailforgot">Enter valid email address</label>
                <div class="input-group">
                    <input type="email" name="email" id="emailforgot" placeholder="Eg - example@gmail.com" class="form-control" maxlength="50" required>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-info text-white mt-2">Send Verification Code</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

{{-- Login with Phone Number --}}
 <div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="phoneModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="phoneModalLabel">Mobile Login</h5>
          <button type="button" class="btn close" style="color: red;" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
        <div class="modal-body">
          <form id="entercancel" action="{{route('frontend.webphonesignin')}}" method="POST" novalidate>
            @csrf
            <div class="form-group py-2">
                <label for="mobile">Contact Number</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">+91</span>
                    </div>
                    <input type="tel" name="mobile" id="mobile" placeholder="9832******" class="form-control" maxlength="10" required>
                </div>
            </div>
            <div id="alertvalid" class="form-group text-danger" style="display: none;">
                <span>Enter a valid number.</span>
            </div>
            <div id="doesnotexist" class="form-group text-danger" style="display: none;">
                <span>Number doesn't exists or Invalid Number.</span>
            </div>
            <div class="text-center">
               <span id="sendotp" class="btn btn-info text-white mt-2">Send OTP</span>
            </div>
            <div id="showotp" style="display: none;">
            <div class="form-group py-1">
                <label for="code"> Verification Code </label>
                <input type="number" name="code" id="code" class="form-control" placeholder="Enter OTP">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-info text-white mt-2">Confirm OTP</button>
            </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
<script>

    $(document).ready(function () {
        $('#entercancel').on('keypress', function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            }
        });

        $('#enterinvalid').on('keypress', function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            }
        });

        $('#sendotp').on('click', function(e) {
            e.preventDefault();
            var mobile = $('#mobile').val();
            var mobilePattern = /^\d{10}$/;
            if (!mobilePattern.test(mobile)) {
                    $('#alertvalid').show();
                    return;
            }
            $('#alertvalid').hide();
            $.ajax({
                url: '/sendotp',
                type: 'POST',
                data: {
                    mobile: mobile,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response)
                {
                    if (response.message) {
                        console.log(response.message);
                        $('#sendotp').hide();
                        $('#doesnotexist').hide();
                        $('#showotp').show();
                    } else if (response.error) {
                        console.log(response.error);
                        $('#doesnotexist').show();
                    } else {
                        console.log('Unexpected response format.');
                        $('#doesnotexist').show();
                    }
                },
                error: function (response) {
                    console.log('Failed to use AJAX.');
                }
            });
        });

        $('#sendsms').on('click', function (e) {
            e.preventDefault();
            var phone = $('#phonenumber').val();
            var phonePattern = /^\d{10}$/;
            if (!phonePattern.test(phone)) {
                $('#alertshow').show();
                return;
            }
            $('#alertshow').hide();
            $.ajax({
                url: '/sendsms',
                type: 'POST',
                data: {
                    phone: phone,
                    _token: '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                success: function (response)
                {
                    if (response.message) {
                        console.log(response.message);
                        $('#closeonverified').hide();
                        $('#alreadyexists').hide();
                        $('#notdisplayable').show();
                    } else if (response.error) {
                        console.log(response.error);
                        $('#alreadyexists').show();
                    } else {
                        console.log('Unexpected response format.');
                        $('#alreadyexists').show();
                    }
                },
                error: function (response) {
                    console.log('Failed to use AJAX.');
                }
            });
        });
    });
</script>
@endsection
