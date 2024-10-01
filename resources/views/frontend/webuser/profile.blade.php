@extends('frontend.partials.body')

@section('body')
<div class="container-xl px-4 my-5">
    <div class="row">
        <div class="col-xl-4">
            @if ($errors->any())
            <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div class="text-center">{{ $error }}</div>
                    @endforeach
            </div>
            @endif
            @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Section</div>
                <div class="card-body text-center">
                    <img class="img-account-profile rounded-circle mb-2" src="{{asset('bdp.png')}}" width="250" height="250" alt="">
                    @if(Auth::guard('webuser')->check())
                        @if(Auth::guard('webuser')->user()->hasRole('donor'))
                        <form action="{{route('frontend.webuserlogout')}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary my-3">Logout</button>
                        </form>
                        @else
                        <a class="btn btn-outline-secondary m-1" onclick="$('#profilemodal').modal('show')">Register as a Blood Donor</a>
                        <form action="{{route('frontend.webuserlogout')}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary my-3">Logout</button>
                        </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card">
                <div class="card-header">Account Details (Edit)</div>
                <div class="card-body">
                {{-- edit for donors --}}
                    @if(Auth::guard('webuser')->check())
                    @if(Auth::guard('webuser')->user()->hasRole('donor'))
                        <form action="{{route('webuser.updatedonordetails')}}" method="POST">
                        @csrf
                        <!-- Form Row -->
                        <div class="row gx-3 mb-3">
                            <div class="col-md-4">
                                <label class="small mb-1" for="name">Name</label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="Enter your name" value="{{Auth::guard('webuser')->user()->name}}">
                            </div>
                            <div class="col-md-4">
                                <label class="small mb-1" for="email">Email</label>
                                <input class="form-control" name="email" id="email" type="email" placeholder="Enter your email" value="{{Auth::guard('webuser')->user()->email}}">
                            </div>
                            <div class="col-md-4">
                                <label class="small mb-1" for="phone">Phone number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+91</span>
                                    </div>
                                    <input type="tel" name="phone" id="phone" value="{{Auth::guard('webuser')->user()->phone}}" placeholder="Enter Contact Number" class="form-control" maxlength="10">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <!-- Form Group (address name)-->
                                <label class="small mb-1" for="donoraddress">Address</label>
                                <textarea name="address" id="donoraddress" class="form-control" cols="20" rows="9">{{Auth::guard('webuser')->user()->profile->address}}</textarea>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (bloodgroup)-->
                            <div class="col-md-5">
                                <label class="small mb-1" for="donor_blood_group">BloodGroup</label>
                                <select name="blood_group" id="donor_blood_group" class="form-select">
                                    <option value="A+" {{ Auth::guard('webuser')->user()->profile->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ Auth::guard('webuser')->user()->profile->blood_group == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ Auth::guard('webuser')->user()->profile->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ Auth::guard('webuser')->user()->profile->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ Auth::guard('webuser')->user()->profile->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ Auth::guard('webuser')->user()->profile->blood_group == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="O+" {{ Auth::guard('webuser')->user()->profile->blood_group == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ Auth::guard('webuser')->user()->profile->blood_group == 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                            </div>
                        </div>
                         <!-- Save changes button-->
                         <a class="btn btn-danger text-white" onclick="$('#resetmodal').modal('show')">Reset Password</a>
                         <button class="btn btn-secondary text-white" type="submit">Save changes</button>
                    </form>
                    <form action="{{route('frontend.seerequestspdf')}}" method="POST">
                        @csrf
                        <button class="btn btn-outline-success my-2 py-2" type="submit"> PDF for Blood Requests Added <i class="fa-regular fa-file-pdf"></i></button>
                    </form>
                    <form action="{{route('frontend.seedonorspdf')}}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger py-2" type="submit"> PDF for Blood Requests Volunteered <i class="fa-regular fa-file-pdf"></i></button>
                    </form>
                @else
                {{-- edit for authenticated users --}}
                <form action="{{route('webuser.updatedetails')}}" method="POST">
                    @csrf
                    <div class="row gx-3 mb-3">
                        <div class="col-md-4">
                            <label class="small mb-1" for="name">Name</label>
                            <input class="form-control" id="name" name="name" type="text" placeholder="Enter your new name" value="{{Auth::guard('webuser')->user()->name}}">
                        </div>
                        <div class="col-md-4">
                            <label class="small mb-1" for="email">Email</label>
                            <input class="form-control" name="email" id="email" type="email" placeholder="Enter your new email" value="{{Auth::guard('webuser')->user()->email}}">
                        </div>
                        <div class="col-md-4">
                            <label class="small mb-1" for="phone">Phone number</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+91</span>
                                </div>
                                <input type="tel" value="{{Auth::guard('webuser')->user()->phone}}" name="phone" id="phone" placeholder="Enter Contact Number" class="form-control" maxlength="10">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-secondary text-white m-1" type="submit">Save Changes</button>
                    <a class="btn btn-danger text-white m-1" onclick="$('#resetmodal').modal('show')">Reset Password</a>
                </form>
                <form action="{{route('frontend.seerequestspdf')}}" method="POST">
                    @csrf
                    <button class="btn btn-outline-success m-1 py-2" type="submit"> PDF for Blood Requests Added <i class="fa-regular fa-file-pdf"></i></button>
                </form>
                @endif
            @endif
            </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="resetmodal" tabindex="-1" role="dialog" aria-labelledby="resetmodalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="resetmodalLabel">Add a new Password</h5>
          <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('frontend.resetpassword')}}" method="POST">
                @csrf
                    <div class="form-group">
                        <label for="password"> Password ( Minimum 8 chars, a Capital letter and 1 Symbol )</label>
                        <input type="password" id="password" name="password" placeholder="Add a new Password" class="form-control">
                    </div>
                    <div class="text-center mt-3">
                    <button type="submit" class="btn btn-danger">Reset Password</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="profilemodal" tabindex="-1" role="dialog" aria-labelledby="profilemodalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="profilemodalLabel">Add Details to register as a Blood Donor</h5>
          <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('frontend.adddetails')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="blood_group">Select Blood Group</label>
                <select name="blood_group" id="blood_group" class="form-control">
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" id="address" class="form-control" cols="30" rows="10" placeholder="Add current location of the donor. Example: 5th Mile, NH 31A, Tadong, Gangtok, Sikkim 737102" maxlength="200"></textarea>
            </div>
            <div class="text-center mt-3">
            <button type="submit" class="btn btn-danger">Add Details</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
@endsection

