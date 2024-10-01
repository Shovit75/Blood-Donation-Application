@extends('backend.partials.app')

@section('body')
<section class="container">
    <div class="my-4">
    <h1>This is the Edit Webuser Section</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif
    @if(session('message'))
    <div class="alert alert-success my-4">
        {{ session('message') }}
    </div>
    @endif
    <br>
        <form action="{{url('/update/webuser/' . $webuser->id)}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="name" name="name" class="form-control" value="{{$webuser->name}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control" value="{{$webuser->email}}">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
              <div class="form-group col-6 mb-2">
                <label for="assign">Assign Roles to Webuser</label>
                <select class="form-control" name="assign">
                    @foreach ($roles as $r)
                        <option value="{{ $r->id }}" {{ in_array($r->id, $selectedRoles) ? 'selected' : '' }}>
                            {{ $r->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="phone">Contact</label>
                    <input type="tel" name="phone" class="form-control" value="{{$webuser->phone}}">
                </div>
            </div>
            </div>
            <button type="submit" class="btn btn-primary">Save changes for webuser</button>
        </form>
        @if ($webuser->hasRole('donor'))
        <hr class="my-4">
        <form action="{{route('webuser.updatewebuserdetails')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{$webuser->id}}">
            <div class="row mb-2">
                <div class="form-group col-6">
                  <label for="blood_group">Blood Group</label>
                  <select name="blood_group" class="form-control">
                    <option value="A+" {{ $webuser->profile->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
                    <option value="A-" {{ $webuser->profile->blood_group == 'A-' ? 'selected' : '' }}>A-</option>
                    <option value="B+" {{ $webuser->profile->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                    <option value="B-" {{ $webuser->profile->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
                    <option value="AB+" {{ $webuser->profile->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
                    <option value="AB-" {{ $webuser->profile->blood_group == 'AB-' ? 'selected' : '' }}>AB-</option>
                    <option value="O+" {{ $webuser->profile->blood_group == 'O+' ? 'selected' : '' }}>O+</option>
                    <option value="O-" {{ $webuser->profile->blood_group == 'O-' ? 'selected' : '' }}>O-</option>
                </select>
                </div>
                <div class="form-group col-6 mb-2">
                  <label for="address">Address</label>
                  <input type="text" class="form-control" name="address" value="{{$webuser->profile->address}}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save changes in profile</button>
        </form>
        @endif
        <hr class="my-4">
        <form action="{{route('webuser.resetpasswordbackend')}}" method="POST">
        @csrf
        <div class="row">
            <div class="form-group col-6 py-3">
                <input type="hidden" name="id" value="{{$webuser->id}}">
                <label for="password">Change Password</label>
                <input type="password" name="password" class="form-control" placeholder="Add a new password">
            </div>
        </div>
          <button type="submit" class="btn btn-primary mb-3">Change Password</button>
        </form>
    </div>
</section>
@endsection
