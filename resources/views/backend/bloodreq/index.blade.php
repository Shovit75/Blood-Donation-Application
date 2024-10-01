@extends('backend.partials.app')

@section('body')
<section class="container">
    <div class="my-4">
        <div class="row">
            <div class="col-md-5 mb-3 mb-md-0">
                <h3 class="text-center">This is the Blood Request Section</h3>
            </div>
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <button class="mx-2 p-2 btn btn-danger border-2 btn-block" onclick="$('#registerModal').modal('show')">Add a New Blood Request</button>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('backend.bloodreq') }}" class="form-inline">
                            <div class="input-group">
                                <input class="form-control" name="search" type="search" placeholder="Search Requests" aria-label="Search">
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
          <tr class="text-center">
            <th scope="col">Patient's Name</th>
            <th scope="col">Blood Group</th>
            <th scope="col">Hospital Name</th>
            <th scope="col">Required Date</th>
            <th scope="col">Recruiter's Name</th>
            <th scope="col">Contact</th>
            <th scope="col">Status</th>
            <th scope="col">Carousel</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($bloodreq as $b)
            <tr class="text-center">
                <td>{{$b->patient_name}}</td>
                <td>{{$b->blood_group}}</td>
                <td>{{$b->hospital_name}}</td>
                <td>{{$b->required_date}}</td>
                <td>{{$b->webuser->name}}</td>
                <td>{{$b->webuser->phone}}</td>
                <td>
                    <input type="checkbox" id="statusCheckbox_{{ $b->id }}" {{ $b->status == 1 ? 'checked' : '' }} onclick="updateStatus({{ $b->id }}, this.checked)">
                </td>
                <td>
                    <input type="checkbox" id="carouselCheckbox_{{ $b->id }}" {{ $b->carousel == 1 ? 'checked' : '' }} onclick="updateCarousel({{ $b->id }}, this.checked)">
                </td>
                <td>
                    <a href="{{url('edit/bloodreq/' . $b->id)}}" class="btn btn-success">Edit</a>
                    <a href="{{url('delete/bloodreq/' . $b->id)}}" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
      <div class="d-flex justify-content-center my-pagination mt-3">
        {{$bloodreq->links()}}
      </div>
    </div>

    {{-- New Bloodcamp Add --}}
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="registerModalLabel">Register New Blood Request</h5>
              <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{route('bloodreq.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Patient's Name</label>
                    <input type="text" name="patient_name" class="form-control">
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="blood_group">Select Blood Group</label>
                        <select name="blood_group" class="form-control">
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="required_date">Required or Before (Date)</label>
                        <input type="date" value="{{ now()->format('Y-m-d') }}" name="required_date" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                <label for="hospital_name">Select Hospital Name</label>
                  <select name="hospital_name" class="form-control">
                    <option value="STNM">STNM Hospital</option>
                    <option value="Manipal">Manipal Hospital</option>
                    <option value="Namchi Hospital">Namchi Hospital</option>
                  </select>
                </div>
                <div class="form-group">
                    <label for="additional_details">Additional Details</label>
                    <textarea name="additional_details" class="form-control" cols="30" rows="7"></textarea>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" class="form-control">
                </div>
                <div class="row mb-3">
                <div class="form-group col-6">
                    <label for="status">Select Status</label>
                    <select class="form-control" name="status">
                        <option value="0">Pending</option>
                        <option value="1">Published</option>
                    </select>
                </div>
                <div class="form-group col-6">
                    <label for="carousel">Select Carousel</label>
                    <select class="form-control" name="carousel">
                        <option value="0">Pending</option>
                        <option value="1">Published</option>
                    </select>
                </div>
                <div class="form-group col-6">
                    <label for="webuser_id">Select WebUser</label>
                    <select class="form-control" name="webuser_id" id="webuser_select">
                    @foreach ($webuser as $w)
                        <option value="{{$w->id}}">{{$w->name}}</option>
                    @endforeach
                    </select>
                </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Register New Blood Request</button>
                </div>
              </form>
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>
</section>

@endsection

@section('scripts')
<script>
    function updateStatus(bloodreqId, isChecked) {
    // Send an AJAX request to update the status
    $.ajax({
        url: '/update-status', // Change this URL to your route that handles the update
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: bloodreqId,
            status: isChecked ? 1 : 0
        },
        success: function(response) {
            // Handle success response
            console.log(response);
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error('Error updating status:', error);
        }
    });
}

function updateCarousel(bloodreqId, isChecked) {
    // Send an AJAX request to update the status
    $.ajax({
        url: '/update-carousel', // Change this URL to your route that handles the update
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: bloodreqId,
            carousel: isChecked ? 1 : 0
        },
        success: function(response) {
            // Handle success response
            console.log('Status updated successfully!');
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error('Error updating status:', error);
        }
    });
}
</script>
{{-- Selectize Plugin --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>
<script>
    $(document).ready(function() {
        $('#webuser_select').selectize({
            maxOptions: 2,
        });
    });
</script>
@endsection
