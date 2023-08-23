@include('home.head')

<body>
    <!-- Start Header/Navigation -->
    @include('home.header')
    <!-- End Header/Navigation -->

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
