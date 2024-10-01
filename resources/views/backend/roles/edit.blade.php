@extends('backend.partials.app')

@section('body')
<section class="container">
    <div class="my-4">
    <h1>This is the Edit Roles Section</h1>
    <br>
        <form action="{{url('/update/roles/' . $roles->id)}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="name" name="name" class="form-control" value="{{$roles->name}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="guardname">Guard Name</label>
                        <input type="text" name="guardname" class="form-control" value="{{$roles->guard_name}}">
                    </div>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="assign">Assign Permissions to Roles</label>
                <select class="form-control" name="assign[]" multiple>
                    @foreach ($permissions as $permission)
                        <option value="{{ $permission->id }}" {{ in_array($permission->id, $selectedPermissions) ? 'selected' : '' }}>
                            {{ $permission->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <br>
              <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</section>
@endsection
