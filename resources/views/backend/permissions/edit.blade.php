@extends('backend.partials.app')

@section('body')
<section class="container">
    <div class="my-4">
    <h1>This is the Edit Permissions Section</h1>
    <br>
        <form action="{{url('/update/permissions/' . $permissions->id)}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="name" name="name" class="form-control" value="{{$permissions->name}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="guardname">Guard Name</label>
                        <input type="text" name="guardname" class="form-control" value="{{$permissions->guard_name}}">
                    </div>
                </div>
            </div>
            <br>
              <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</section>
@endsection
