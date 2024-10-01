@extends('backend.partials.app')

@section('body')
<section class="container">
    <div class="my-4">
    <h1>This is the Edit Admin Section</h1>
    <br>
        <form action="{{url('/update/admin/' . $admins->id)}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="name" name="name" class="form-control" value="{{$admins->name}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control" value="{{$admins->email}}">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
              <div class="form-group col-6">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" value="{{$admins->password}}">
              </div>
            </div>
              <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</section>
@endsection
