@extends('frontend.partials.body')

@section('body')
{{-- Card Carousel --}}
<section class="mt-4 mb-2">
    <div class="container">
        @if(session('message'))
        <div class="m-4">
            <div class="alert alert-success alert-dismissible fade show px-4" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
        <h2 class="text-center py-3 charcoal">Active Requirements for <span class="primarycolor fw-bold">Blood Requests</span></h2>
        <div class="row">
            <div class="col-12 m-auto">
                @if(count($bloodreq) > 0)
                    <div class="owl-carousel owl-theme">
                        @foreach ($bloodreq as $item)
                        <div class="item">
                            <div class="card border-2">
                                <a href="{{ route('frontend.reqslug', ['slug' => $item->slug]) }}">
                                <img src="/newpng.png" class="card-img-top p-3 card-img border" alt="Image">
                                <div class="card-body text-center">
                                    <h5><span class="mx-1 greyshade" style="font-weight: 600;">{{ $item->hospital_name }}</span></h5><hr>
                                    <p class="charcoal">
                                        <span><i class="fa-solid fa-hospital-user" style="color: #33B1AF"></i> <span class="mx-1">{{ $item->patient_name }}</span></span><br>
                                        <span><i class="fa-regular fa-calendar" style="color: #33B1AF"></i> <span class="mx-1">{{ \Carbon\Carbon::parse($item->required_date)->format('d-M-Y') }}</span></span>
                                    </p>
                                </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <h3 class="text-center pt-4">No Blood Requests Added Yet.</h3>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Eligibility Criteria --}}
<section class="section-big main-color">
   <div class="container">
      <div class="row mb-4 mx-1">
         <div class="col-md-12 text-center">
            <h2 class="text-center mt-5 mb-3 charcoal">Who can <span class="primarycolor fw-bold">Donate Blood ?</span>!</h2>
            <p class="section-sub-title charcoal">
               Here is a list of factors one must under-go as an eligibility criteria for blood donation.
            </p>
            <div class="exp-separator center-separator">
               <div class="exp-separator-inner">
               </div>
            </div>
         </div>
      </div>
      <div class="row mx-1 charcoal">
         <div class="col-md-4">
            <ul class="i-list medium">
               <li class="i-list-item">
                  <div class="icon"> <i class="fa-solid fa-person-cane"></i> </div>
                  <div class="icon-content">
                     <h3 class="title">Age</h3>
                     <p class="sub-title">
                        Donors usually need to be within a certain age range,
                        often between 18 and 65 years old.
                     </p>
                  </div>
                  <div class="iconlist-timeline"></div>
               </li>
               <li class="i-list-item">
                  <div class="icon"> <i class="fa-solid fa-weight-scale"></i> </div>
                  <div class="icon-content">
                     <h3 class="title">Weight</h3>
                     <p>
                        Donors typically need to weigh at least a certain amount,
                        usually around 110 pounds (50 kilograms).
                     </p>
                  </div>
                  <div class="iconlist-timeline"></div>
               </li>
               <li class="i-list-item">
                  <div class="icon"> <i class="fa-solid fa-notes-medical"></i> </div>
                  <div class="icon-content">
                     <h3 class="title">Health Status</h3>
                     <p>
                        Donors must be in good health at the time of donation.
                        They should not have any acute illnesses, infections,
                        or chronic health conditions.
                     </p>
                  </div>
               </li>
            </ul>
         </div>
         <div class="col-md-4">
            <ul class="i-list medium">
               <li class="i-list-item">
                  <div class="icon"> <i class="fa-solid fa-truck-medical"></i> </div>
                  <div class="icon-content">
                     <h3 class="title">Travel History</h3>
                     <p>
                        Recent travel to certain countries or regions with high prevalence
                        of infectious diseases may temporarily defer donation.
                     </p>
                  </div>
                  <div class="iconlist-timeline"></div>
               </li>
               <li class="i-list-item">
                <div class="icon"> <i class="fa-solid fa-book-medical"></i> </div>
                <div class="icon-content">
                   <h3 class="title">Medical History</h3>
                   <p class="sub-title">
                      Donors are usually asked about their medical history,
                      including any past or current medical conditions, surgeries, or treatments.
                   </p>
                </div>
                <div class="iconlist-timeline"></div>
               </li>
               <li class="i-list-item">
                  <div class="icon"> <i class="fa-regular fa-pen-to-square"></i> </div>
                  <div class="icon-content">
                     <h3 class="title">Piercing and Tattoos</h3>
                     <p>
                        Donors may be deferred for a certain period after getting a new piercing
                        or tattoo to reduce the risk of transmitting infections.
                     </p>
                  </div>
               </li>
            </ul>
         </div>
         <div class="col-md-4">
            <ul class="i-list medium">
               <li class="i-list-item">
                  <div class="icon"> <i class="fa-solid fa-person-pregnant"></i> </div>
                  <div class="icon-content">
                     <h3 class="title">Pregnancy and Recent Childbirth</h3>
                     <p class="sub-title">
                        Pregnant individuals and those who have given birth within the past few months are usually
                        deferred from donating blood.
                     </p>
                  </div>
                  <div class="iconlist-timeline"></div>
               </li>
               <li class="i-list-item">
                  <div class="icon"> <i class="fa-solid fa-droplet"></i> </div>
                  <div class="icon-content">
                     <h3 class="title">Blood Pressure</h3>
                     <p>
                        Hypertension (high blood pressure) or hypotension (low blood pressure) may affect eligibility.
                     </p>
                  </div>
                  <div class="iconlist-timeline"></div>
               </li>
               <li class="i-list-item">
                  <div class="icon"> <i class="fa-solid fa-stethoscope"></i> </div>
                  <div class="icon-content">
                     <h3 class="title">Medications</h3>
                     <p>
                        Donors are typically asked about any prescription or over-the-counter medications they are currently taking.
                     </p>
                  </div>
               </li>
            </ul>
         </div>
      </div>
   </div>
</section>

{{-- Relevant Images --}}
<section>
    <div class="container pb-5">
        <div class="mx-1">
        <h2 class="text-center pb-4 charcoal">Some Relevant Context for <span class="primarycolor fw-bold">Blood Donation</span></h2>
        <div class="row">

            <div class="col-md-6">
                <img src="{{ asset('/donorcomp.png') }}" alt="" class="img-fluid imagegroup border shadow">
            </div>
            <div class="col-md-6">
                <img src="{{ asset('/bdp2.jpg') }}" alt="" class="img-fluid imagegroup border shadow thumbnail">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <img src="{{ asset('/bdp1.jpg') }}" alt="" class="img-fluid imagegroup border shadow">
            </div>
            <div class="col-md-6">
                <img src="{{ asset('/blabla.jpg') }}" alt="" class="img-fluid imagegroup border shadow">
            </div>

        </div>
    </div>
    </div>
</section>
@endsection

@section('head')
{{-- links for owl carousel --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
            integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
            crossorigin="anonymous" />
    <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
            integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
            crossorigin="anonymous" />
    {{-- minified link for styling the index only --}}
    <link href="/index.css" rel="stylesheet">
@endsection

@section('scripts')
{{-- script for owl carousel --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
crossorigin="anonymous"></script>

<script>

var itemCount = $(".owl-carousel .item").length;
var loopEnabled = itemCount >= 5; // Set loop to true only if there are more than 5 items
var autoplayEnabled = itemCount >= 5; // Set autoplay to true only if there are more than or equal to 5 items

$('.owl-carousel').owlCarousel({
    loop: loopEnabled,
    margin: 15,
    autoplay: autoplayEnabled,
    autoplayTimeout: 3500,
    dots: false,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 2
        },
        800:{
            items: 3
        },
        1000: {
            items: 4
        },
        1200:{
            items: 5
        }
    }
})
</script>
@endsection
