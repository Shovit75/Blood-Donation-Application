</body>

<!-- Footer -->
<footer class="text-start text-responsive-center bg-body-tertiary pb-3" style="background-color: #33B1AF">
    <!-- Section: Links  -->
    <section class="py-2">
      <div class="container mt-5">
        <!-- Grid row -->
        <div class="row mt-3">
          <!-- Grid column -->
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <!-- Content -->
            <p class="text-uppercase mb-4" style="color: white; font-weight: 1000;">
                © Blood.Sikkim.Co
            </p>
            <p style="color: white">
                Focuses on encouraging voluntary blood donation.
            </p>
          </div>

          <!-- Grid column -->
          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4" style="color: white">
              Navigation Links
            </h6>
            <p style="color: white">
              <a href="{{route('frontend.bdcamps')}}" class="text-reset">Blood Donation Camps</a>
            </p>
            <p style="color: white">
              <a href="{{route('frontend.activereq')}}" class="text-reset">Active Requirements</a>
            </p>
            <p style="color: white">
              <a href="{{route('frontend.about')}}" class="text-reset">About Us</a>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4" style="color: white">Contact</h6>
            <p style="color: white"><i class="fas fa-home me-3"></i> Opp. State Bank of Sikkim,<br>
            Metro point, Tadong, Gangtok,<br> East Sikkim, 737102
            </p>
            <p style="color: white">
              <i class="fas fa-envelope me-3"></i>
              support@sikkimbloodco.com
            </p>
            <p style="color: white"><i class="fas fa-phone me-3"></i> +91-9894178970</p>
          </div>
          <!-- Grid column -->
        </div>
        <hr class="mb-4">
        <!-- Grid row -->
      </div>
    </section>
  </footer>
  <!-- Footer -->

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- JQuery script-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
@yield('scripts')
</html>
