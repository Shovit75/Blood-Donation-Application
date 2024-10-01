@extends('backend.partials.app')

@section('body')
<section class="container">
    <div class="my-4">
    <h1>This is the Edit Blood Request Section</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif
    @if(session('message'))
    <div class="alert alert-success my-4">
        {{ session('message') }}
    </div>
    @endif
    <br>
        <form action="{{url('/update/bloodreq/' . $bloodreq->id)}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="patient_name">Patient Name</label>
                        <input type="name" name="patient_name" class="form-control" value="{{$bloodreq->patient_name}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="hospital_name">Hospital Name</label>
                        <select name="hospital_name" class="form-control">
                            <option value="STNM" {{ $selectedhospital == 'STNM' ? 'selected' : '' }}>STNM Hospital</option>
                            <option value="Manipal" {{ $selectedhospital == 'Manipal' ? 'selected' : '' }}>Manipal Hospital</option>
                            <option value="Namchi Hospital" {{ $selectedhospital == 'Namchi_Hospital' ? 'selected' : '' }}>Namchi Hospital</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="required_date">Required Date</label>
                        <input type="date" name="required_date" class="form-control" value="{{$bloodreq->required_date}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="blood_group">Blood Group</label>
                        <select name="blood_group" class="form-control">
                            <option value="A+" {{ $selectedbloodgroup == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ $selectedbloodgroup == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ $selectedbloodgroup == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ $selectedbloodgroup == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ $selectedbloodgroup == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ $selectedbloodgroup == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ $selectedbloodgroup == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ $selectedbloodgroup == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                <label for="additional_details">Additional Details</label>
                <textarea name="additional_details" class="form-control" id="" cols="30" rows="10">{{$bloodreq->additional_details}}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status">
                            <option value="0" {{ $selectedstatus == 0 ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ $selectedstatus == 1 ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="carousel">carousel</label>
                        <select class="form-control" name="carousel">
                            <option value="0" {{ $selectedcarousel == 0 ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ $selectedcarousel == 1 ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="webuser_id">Recruiter</label>
                        <select class="form-control" name="webuser_id" id="webuser_select">
                            @foreach ($webuser as $w)
                                <option value="{{ $w->id }}" {{ $w->id == $bloodreq->webuser_id ? 'selected' : '' }}>{{ $w->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" class="form-control" value="{{$bloodreq->slug}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
        <form action="{{route('frontend.downloadpdf')}}" method="POST">
            @csrf
            <input type="hidden" name="bdreqid" value="{{$bloodreq->id}}">
            <button class="btn btn-outline-danger" type="submit"><i class="fa-regular fa-file-pdf"></i> Download Donors PDF </button>
        </form>
        <hr class="my-3">
        <form action="{{ route('update_donors', ['bloodreqId' => $bloodreq->id]) }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="donors" class="py-2">Edit Donors for the Request (Update Only When Required) </label>
                @php
                    $donors = json_decode($bloodreq->donors, true);
                @endphp
                <input type="hidden" name="bdreqid" value="{{$bloodreq->id}}">
                @if (!empty($donors))
                    @foreach ($donors as $key => $donor)
                        <div class="donor-details py-2">
                            <input type="hidden" name="donors[{{ $key }}][id]" value="{{ $donor['id'] }}" placeholder="Id">
                            <input type="text" name="donors[{{ $key }}][name]" value="{{ $donor['name'] }}" placeholder="Name">
                            <input type="text" name="donors[{{ $key }}][blood_group]" value="{{ $donor['blood_group'] }}" placeholder="Blood Group">
                            <input type="text" name="donors[{{ $key }}][address]" value="{{ $donor['address'] }}" placeholder="Address">
                            <input type="text" name="donors[{{ $key }}][phone]" value="{{ $donor['phone'] }}" placeholder="Phone">
                            <a href="#" class="btn btn-danger remove-donor" data-key="{{ $key }}">X</a>
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-success mt-3">Update Donors Data</button>
                @else
                    <div>No donors available.</div>
                @endif
            </div>
        </form>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.remove-donor').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                var key = this.getAttribute('data-key');
                var donorContainer = this.closest('.donor-details');
                donorContainer.remove();
            });
        });
    });
</script>
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
