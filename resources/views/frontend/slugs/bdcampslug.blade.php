@extends('frontend.partials.body')

@section('body')
<section class="container my-5">
    <div class="container">
    <div class="text-center py-5">
        {{--Here content--}}
        @if(session('message'))
        <div class="m-4">
            <div class="alert alert-success alert-dismissible fade show px-4" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
        <h1 class="py-2">Blood Donation Camp Details</h1>
        @if ($bdcamps->image)
        <p class="py-2"><img src="{{asset('/'.$bdcamps->image)}}" alt="Image" class="img-fluid" width="260"></p>
        @else
        <div class="py-2"></div>
        @endif
        <p><strong>BD Camp Name:</strong> {{ $bdcamps->name }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($bdcamps->date)->format('d-M-Y') }}</p>
        <p><strong>Location:</strong> {{ $bdcamps->location }}</p>
        <p><strong>Description:</strong> {{ $bdcamps->description }}</p>
                @if(Auth::guard('webuser')->check())
                    @if(Auth::guard('webuser')->user()->hasRole('donor'))
                    <form action="{{route('frontend.participate')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$bdcamps->id}}">
                        <input type="hidden" name="participant" value="{{Auth::guard('webuser')->user()->name}}" >
                        <button type="submit" class="btn btn-outline-secondary m-2">Volunteer for blood camp</button>
                    </form>
                    @else
                        <a href="{{route('frontend.webuserprofile')}}" class="btn btn-outline-secondary m-2">Register as a Blood Donor to Participate</a>
                    @endif
                    @else
                    <a href="{{route('frontend.webuserlogin')}}" class="btn btn-outline-secondary m-2">Login to Participate</a>
                @endif
    </div>
</div>
</section>
@endsection
