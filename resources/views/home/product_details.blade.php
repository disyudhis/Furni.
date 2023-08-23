@include('home.head')

<body>
    <!-- Start Header/Navigation -->
    @include('home.header')
    <!-- End Header/Navigation -->

    @include('sweetalert::alert')

    {{-- start body section --}}


    <!-- Start Why Choose Us Section -->
    <div class="why-choose-section">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-5 m-3" style="border-right: 1px solid rgba(0, 0, 0, 0.2); height: 100%; margin: 0 15px">
                    <div class="img-wrap pr-5">
                        <img src="/product/{{ $product->image }}" alt="Image" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-6">
                    <figure>
                        <blockquote class="blockquote">
                            <h4 class="display-5 text-black">{{ $product->title }}</h4>
                        </blockquote>
                        <figcaption class="blockquote-footer">
                            The Most Anticipated Furniture in Town |<cite> Furni.</cite>
                        </figcaption>
                    </figure>

                    <div class="row my-3">
                        <div class="col-md-6">
                            <div class="feature">
                                @if ($product->discount_price != null)
                                    <p>Original Price : <span style="color: red; text-decoration: line-through">Rp.
                                            {{ $product->price }}</span> </p>
                                    <h4 class="display-6"><span style="color: green; font-weight: 600">Rp.
                                            {{ $product->discount_price }}</span> </h4>
                                @else
                                    <h4 class="display-6"><span style="color: green; font-weight: 600">Rp.
                                            {{ $product->price }}</span> </h4>
                                @endif
                                <hr>
                                <p>Stock : {{ $product->quantity }}</p>
                                <form action="{{ url('/add_cart') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6 col-md-4">
                                            <input class="form-control" type="number" min="1" value="1">
                                        </div>
                                        <div class="col-6 col-md-8">
                                            <a class="btn btn-primary" type="submit">Add To Cart</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Why Choose Us Section -->


    {{-- End body section --}}

    <!-- Start Footer Section -->
    @include('home.footer')
    <!-- End Footer Section -->


    @include('home.script')
</body>

</html>
