@extends('frontend.partials.body')

@section('body')
<section class="container my-5">
    <h3 class="text-center charcoal py-2">Nearby <span class="primarycolor fw-bold">Blood Donation Camps</span></h3>
    <div class="row justify-content-center">
        @foreach ($bdcamps as $b)
        <div class="col-md-4 py-4">
            <div class="card">
                <a href="{{ route('frontend.bdcampslug', ['slug' => $b->slug]) }}">
                <img src="{{asset('/'.$b->image)}}" class="card-img-top p-2 border" width="100" height="350" alt="Image">
                <div class="card-body text-center charcoal">
                <h5 class="card-title fw-bold py-2 greyshade">{{$b->name}}</h5>
                <hr>
                <p class="card-text"><i class="fa-solid fa-hospital-user primarycolor"></i> {{$b->location}}</p>
                <p class="card-text"><i class="fa-regular fa-calendar primarycolor"></i> {{ \Carbon\Carbon::parse($b->date)->format('d-M-Y') }}</p>
              </div>
            </a>
            </div>
          </div>
        @endforeach
    </div>
</section>@endsection
