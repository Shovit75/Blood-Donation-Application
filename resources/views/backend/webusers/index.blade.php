@extends('backend.partials.app')

@section('body')
<section class="container">
    <div class="my-4">
        <div class="row">
            <div class="col-md-5 mb-3 mb-md-0">
                <h2 class="text-center">This is the Webuser Section</h2>
            </div>
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <button class="mx-2 p-2 btn btn-danger border-2 btn-block" onclick="$('#registerModal').modal('show')">Add Webuser</button>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('backend.webuser') }}" class="form-inline">
                            <div class="input-group">
                                <input class="form-control" name="search" type="search" placeholder="Search Webusers" aria-label="Search">
                                <button class="btn btn-outline-danger" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <br>
    @if ($errors->any())
    <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
    </div>
    @endif
    @if(session('message'))
    <div class="alert alert-success py-3">
        {{ session('message') }}
    </div>
    @endif
    <div class="table-responsive">
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Contact</th>
            <th scope="col">Roles</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($webuser as $w)
            <tr>
                <th>{{$w->id}}</th>
                <td>{{$w->name}}</td>
                <td>{{$w->email}}</td>
                <td>{{$w->phone}}</td>
                <td>
                    @foreach ($w->roles as $r)
                    {{ $r->name }} <br>
                    @endforeach
                </td>
                <td>
                    <a href="{{url('edit/webuser/' . $w->id)}}" class="btn btn-success">Edit</a>
                    <a href="{{url('delete/webuser/' . $w->id)}}" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
      <div class="d-flex justify-content-center my-pagination mt-3">
        {{$webuser->links()}}
      </div>
    </div>

    {{-- New Webuser Add --}}
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="registerModalLabel">Register New User</h5>
              <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{route('webuser.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="phone">Contact</label>
                    <input type="tel" name="phone" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Register New WebUser</button>
              </form>
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>
</section>
@endsection
