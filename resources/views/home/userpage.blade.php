@include('home.head')

<body>
    <!-- Start Header/Navigation -->
    @include('home.header')
    <!-- End Header/Navigation -->

    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Modern Interior <span clsas="d-block">Design Studio</span></h1>
                        <p><a href="#shop"
                                class="btn btn-white-outline">Explore</a></p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="hero-img-wrap">
                        <img src="{{ asset('dashboard/images/couch.png') }}" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    @include('sweetalert::alert')

    {{-- start body section --}}
    @include('home.body')
    {{-- End body section --}}

    <!-- Start Footer Section -->
    @include('home.footer')
    <!-- End Footer Section -->


    @include('home.script')
</body>

</html>
