@extends('backend.partials.app')

@section('body')
<section class="container">
    <div class="my-4">
    <h1>This is the Edit Bloodcamps Section</h1>
    <br>
    @if ($errors->any())
    <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div class="text-center">{{ $error }}</div>
            @endforeach
    </div>
    @endif
        <form action="{{url('/update/bloodcamps/' . $bloodcamps->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="name" name="name" class="form-control" value="{{$bloodcamps->name}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" name="location" class="form-control" value="{{$bloodcamps->location}}">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group col-md-8">
                  <label for="description">Description</label>
                  <textarea class="form-control" name="description" id="" cols="30" rows="10">{{$bloodcamps->description}}</textarea>
                </div>
                <div class="col-md-4">
                    <label for="image">Image</label><br>
                    <input type="file" name="image" class="form-control">
                    @if($bloodcamps->image)
                    <img src="{{ asset('/' . $bloodcamps->image) }}" class="img-fluid p-2" width="280" alt="Description of Image">
                    @endif
                </div>
            </div>
            <br>
            <div class="row">
              <div class="form-group col-md-4">
                <label for="date">Date</label>
                <input type="date" name="date" class="form-control" value="{{$bloodcamps->date}}">
              </div>
              <div class="form-group col-md-8">
                <label for="slug">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{$bloodcamps->slug}}">
              </div>
            </div>
            <br>
              <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <form action="{{route('frontend.downloadparticipantspdf')}}" method="POST">
            @csrf
            <input type="hidden" name="bdcampsid" value="{{$bloodcamps->id}}">
            <button class="btn btn-outline-danger my-3" type="submit"><i class="fa-regular fa-file-pdf"></i> Download Participants PDF </button>
        </form>
        <hr>
        <form action="{{route('bloodcamp.updateparticipants')}}" method="POST">
            @csrf
            <div class="form-group my-4">
                <label for="donors" class="py-2">Edit Paticipants for the BD camp (Edit only when necessary)</label>
                @php
                    $participants = $bloodcamps->participants;
                @endphp
                <input type="hidden" name="bdcampsid" value="{{$bloodcamps->id}}">
                @if (!empty($participants))
                    @foreach ($participants as $key => $donor)
                        <div class="donor-details py-1">
                            <input type="hidden" name="participants[{{ $key }}][participantId]" value="{{ $donor['participantId'] }}" placeholder="Id">
                            <input class="col-12 col-md-3" type="text" name="participants[{{ $key }}][participantName]" value="{{ $donor['participantName'] }}" placeholder="Name">
                            <input class="col-12 col-md-3" type="text" name="participants[{{ $key }}][participantPhone]" value="{{ $donor['participantPhone'] }}" placeholder="Phone">
                            <input class="col-12 col-md-3" type="text" name="participants[{{ $key }}][participantAddress]" value="{{ $donor['participantAddress'] }}" placeholder="Address">
                            <input class="col-12 col-md-2" type="text" name="participants[{{ $key }}][participantBg]" value="{{ $donor['participantBg'] }}" placeholder="BloodGroup">
                            <a href="#" class="btn btn-danger remove-donor" data-key="{{ $key }}">X</a>
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary mt-2">Save Changes</button>
                @else
                    <div>No participants available.</div>
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
@endsection
