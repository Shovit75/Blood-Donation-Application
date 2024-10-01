@extends('backend.partials.app')

@section('body')
<section class="container">
    <div class="mt-4">
    <h1 class="text-center">This is the Dashboard</h1>
    @if(Auth::check())
        <p class="p-2 text-center">Welcome, {{ Auth::user()->name }}</p>
        <div class="row text-center">
            <div class="col-sm-4">
              <div class="card mb-3">
                <div class="card-body">
                  <img src="{{asset('bdp.png')}}" width="300" class="img-fluid" alt="">
                  <h5 class="card-title">Bloodcamps</h5>
                  <p class="card-text">All Bloodcamps: {{$bdcamps}}</p>
                  <a href="{{route('backend.bloodcamps')}}" class="btn btn-outline-danger mb-3">Go to Bloodcamps Panel</a>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card mb-3">
                <div class="card-body">
                <img src="{{asset('bdp.png')}}" width="300" class="img-fluid" alt="">
                <h5 class="card-title">Blood Requests</h5>
                <p class="card-text">All Bloodcamps: {{$bloodreq}}</p>
                <a href="{{route('backend.bloodreq')}}" class="btn btn-outline-danger mb-3">Go to Blood Requests Panel</a>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
                <div class="card mb-3">
                  <div class="card-body">
                    <img src="{{asset('bdp.png')}}" width="300" class="img-fluid" alt="">
                    <h5 class="card-title">Web Users</h5>
                    <p class="card-text">All Webusers: {{$webusers}}</p>
                    <a href="{{route('backend.webuser')}}" class="btn btn-outline-danger mb-3">Go to Webusers Panel</a>
                  </div>
                </div>
              </div>
          </div>
    </div>
    <!-- Display other user information -->
    @else
    <p>User not logged in</p>
    @endif
</section>
@endsection
