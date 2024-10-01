@extends('frontend.partials.body')

@section('body')
    <section class="container my-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div class="text-center">{{ $error }}</div>
                @endforeach
            </div>
        @endif
        @if(session('message'))
            <div class="alert alert-success">
                <div class="text-center">{{ session('message') }}</div>
            </div>
        @endif
        <h3 class="text-center fw-bold py-3">Active Requirements for <span class="text-danger" >Searched Blood Requests</span></h3>
        @if (Auth('webuser')->check())
        <div class="text-center">
            <button type="submit" class="btn btn-outline-secondary py-2 mb-3" onclick="$('#bloodreqmodal').modal('show')">Add Blood Request</button>
        </div>
        @else
        <div class="text-center">
            <a href="{{route('frontend.webuserlogin')}}" class="btn btn-outline-secondary py-2 mb-3">Sign in to add Blood Requests</a>
        </div>
        @endif
        <div class="row justify-content-center">
            @if(count($bloodreq) > 0)
            @foreach ($bloodreq as $b)
            <div class="col-md-3 py-3">
                <div class="card">
                    <a href="{{ route('frontend.reqslug', ['slug' => $b->slug]) }}">
                    <img src="/bdp.png" class="card-img-top p-3 border" width="100" height="250" alt="Image">
                    <div class="card-body text-center">
                    <h5 class="card-title py-2"><i class="fa-solid fa-hospital"></i> {{$b->hospital_name}}</h5>
                    <p class="card-text"><i class="fa-solid fa-hospital-user"></i> {{$b->patient_name}}</p>
                    <p class="card-text"><i class="fa-regular fa-calendar"></i> {{$b->required_date}}</p>
                  </div>
                </a>
                </div>
              </div>
            @endforeach
            {{-- <div class="d-flex justify-content-center my-pagination mt-3">
                {{$bloodreq->links()}}
            </div> --}}
            @else
            <h3 class="text-center py-5">No Requests Added Yet.</h3>
            <div style="padding:85px;"></div>
            @endif
        </div>
    </section>


 {{-- New Blood Req Add --}}
 <div class="modal fade" id="bloodreqmodal" tabindex="-1" role="dialog" aria-labelledby="bloodreqmodalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bloodreqmodalLabel">Add New Blood Request</h5>
          <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('frontend.addblood')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Patient's Name</label>
                <input type="text" id="name" name="patient_name" class="form-control" placeholder="Add name of the Patient">
            </div>
            <div class="row">
                <div class="form-group py-2 col-6">
                    <label for="blood_group">Select Blood Group</label>
                    <select name="blood_group" id="blood_group" class="form-select">
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
                <div class="form-group py-2 col-6">
                    <label for="date">Required Date</label>
                    <input type="date" id="date" value="{{ now()->format('Y-m-d') }}" name="required_date" class="form-control">
                </div>
            </div>
            <div class="form-group py-2">
                <label for="hospital_name">Select Hospital</label>
                <select name="hospital_name" id="hospital_name" class="form-select">
                    <option value="STNM">STNM Hospital</option>
                    <option value="Manipal">Manipal Hospital</option>
                    <option value="Namchi Hospital">Namchi Hospital</option>
                </select>
            </div>
            <div class="form-group py-2">
                <label for="additional_details">Additional Details</label>
                <textarea name="additional_details" id="additional_details" class="form-control" cols="30" rows="10" placeholder="Not a compulsion to add." maxlength="200"></textarea>
            </div>
            <div class="row">
            <div class="form-group py-2 col-6">
                <input type="hidden" name="webuser_id" value="{{Auth::guard('webuser')->id()}}">
                <input type="hidden" name="status" value="0">
            </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-danger">Add Blood Request</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
@endsection
