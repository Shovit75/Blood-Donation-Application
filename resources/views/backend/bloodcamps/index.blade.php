@extends('backend.partials.app')

@section('body')
<section class="container">
    <div class="my-4 d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="mb-3 mb-md-0 text-center">This is the Bloodcamps Section</h1>
    <button class="mx-0 mx-md-4 my-2 my-md-0 p-2 btn btn-danger border-2" onclick="$('#registerModal').modal('show')">Add Bloodcamp</button>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div class="text-center">{{ $error }}</div>
            @endforeach
    </div>
    @endif
    <div class="table-responsive">
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Date</th>
            <th scope="col">Location</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($bloodcamps as $b)
            <tr>
                <th>{{$b->id}}</th>
                <th>{{$b->name}}</th>
                <td>{{$b->date}}</td>
                <td>{{$b->location}}</td>
                <td>
                    <a href="{{url('edit/bloodcamps/' . $b->id)}}" class="btn btn-success">Edit</a>
                    <a href="{{url('delete/bloodcamps/' . $b->id)}}" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
      <div class="d-flex justify-content-center my-pagination mt-3">
        {{$bloodcamps->links()}}
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
              <form action="{{route('bloodcamps.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" class="form-control">
                </div>
                <div class="form-group py-4">
                    <label for="image">Image: </label>
                    <input type="file" id="image" name="image" class="form-control-file">
                </div>
                <div class="form-group mb-3">
                    <label for="location">Date</label>
                    <input type="date" name="date" class="form-control">
                </div>
                <button type="submit" class="btn btn-danger">Register New Bloodcamp</button>
              </form>
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>
</section>
@endsection
