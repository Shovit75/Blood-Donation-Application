@extends('backend.partials.app')

@section('body')
<section class="container">
    <div class="my-4">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <h2 class="text-center">This is the Permissions Section</h2>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <button class="mx-2 p-2 btn btn-primary border-2 btn-block" onclick="$('#registerModal').modal('show')">Add a New Permission</button>
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
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $p)
            <tp>
                <th>{{$p->id}}</th>
                <th>{{$p->name}}</th>
                <td>{{$p->guard_name}}</td>
                <td>
                    <a href="{{url('edit/permissions/' . $p->id)}}" class="btn btn-success">Edit</a>
                    <a href="{{url('delete/permissions/' . $p->id)}}" class="btn btn-danger">Delete</a>
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
              <h5 class="modal-title" id="registerModalLabel">Register New Permission</h5>
              <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{route('permissions.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group mb-2">
                    <label for="guardname">Guard Name</label>
                    <input type="text" name="guardname" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Register New Permission</button>
              </form>
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>
</section>
@endsection
