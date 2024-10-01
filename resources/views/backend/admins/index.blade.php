@extends('backend.partials.app')

@section('body')
<section class="container">
    <div class="my-4">
    <h2 class="text-center">This is the Admin User Section</h2>
    <br>
    <div class="table-responsive">
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($admins as $a)
            <tr>
                <th>{{$a->id}}</th>
                <td>{{$a->name}}</td>
                <td>{{$a->email}}</td>
                <td>
                    <a href="{{url('edit/admin/' . $a->id)}}" class="btn btn-success">Edit</a>
                    <a href="{{url('delete/admin/' . $a->id)}}" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
    </div>
</section>
@endsection
