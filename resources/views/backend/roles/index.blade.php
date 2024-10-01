@extends('backend.partials.app')

@section('body')
<section class="container">
    <div class="my-4">
        <div class="row">
            <div class="col-md-5 mb-3 mb-md-0">
                <h2 class="text-center">This is the Roles Section</h2>
            </div>
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <button class="mx-2 p-2 btn btn-primary border-2 btn-block" onclick="$('#registerModal').modal('show')">Add a New Role</button>
                    </div>
                    <!-- Add more content if needed -->
                </div>
            </div>
        </div>
    <br>
    <div class="table-responsive">
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Guard Name</th>
            <th scope="col">Permissions Assigned</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($roles as $r)
            <tr>
                <th>{{$r->id}}</th>
                <th>{{$r->name}}</th>
                <td>{{$r->guard_name}}</td>
                <td>
                    @foreach ($r->permissions as $permission)
                    {{ $permission->name }} <br>
                    @endforeach
                </td>
                <td>
                    <a href="{{url('edit/roles/' . $r->id)}}" class="btn btn-success">Edit</a>
                    <a href="{{url('delete/roles/' . $r->id)}}" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
    </div>


    {{-- New Bloodcamp Add --}}
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="registerModalLabel">Register New Bloodcamp</h5>
              <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{route('roles.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="guardname">Guard Name</label>
                    <input type="text" name="guardname" class="form-control">
                </div>
                <div class="form-group mb-2">
                    <label for="assign">Assign Permissions to Roles</label>
                    <select class="form-control" name="assign[]" multiple>
                        @foreach ($permissions as $p)
                            <option value="{{$p->id}}">{{$p->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Register New Role</button>
              </form>
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>
</section>

@endsection
