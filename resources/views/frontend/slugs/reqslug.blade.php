@extends('frontend.partials.body')

@section('body')
<section class="container my-5">
    <div class="container">
    <div class="text-center">
        {{--Here content--}}
        <h1 class="py-3">Blood Request Details</h1>
        @if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
        @if(Auth::guard('webuser')->check())
                    @if(Auth::guard('webuser')->user()->hasRole('donor'))
                    <div class="py-1 mb-3">
                        <form action="{{route('frontend.senddonordetails')}}" method="POST">
                        @csrf
                        <input type="hidden" name="bdreqid" value="{{$bloodreq->id}}">
                        <button class="btn btn-outline-secondary">Provide Details for {{$bloodreq->patient_name}}</button>
                        </form>
                    </div>
                    @else
                    <div class="py-1 mb-3">
                        <a class="btn btn-outline-secondary" href="{{route('frontend.webuserprofile')}}">Register as a Donor to provide details</a>
                    </div>
                    @endif
                    @else
                    <div class="py-1 mb-3">
                        <a class="btn btn-outline-secondary" href="{{route('frontend.webuserlogin')}}">Login to help {{ $bloodreq->patient_name }}</a>
                    </div>
                    @endif
        <p><strong>Patient's Name:</strong> {{ $bloodreq->patient_name }}</p>
        <p><strong>Recruiter's Name:</strong> {{ $bloodreq->webuser->name }}</p>
        <p><strong>Blood Group:</strong> {{ $bloodreq->blood_group }}</p>
        <p><strong>Hospital Name:</strong> {{ $bloodreq->hospital_name }}</p>
        <p><strong>Required Date:</strong> {{ \Carbon\Carbon::parse($bloodreq->required_date)->format('d-M-Y') }}</p>
        @if(!empty($bloodreq->additional_details))
        <p class="pb-4"><strong>Additional Details:</strong> {{ $bloodreq->additional_details }}</p>
        @else
        <p class="pb-4"><strong>Additional Details:</strong> Not added</p>
        @endif
    </div>
</div>
</section>
@endsection
