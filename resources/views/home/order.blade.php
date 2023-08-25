@include('home.head')

<body>
    <!-- Start Header/Navigation -->
    <nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Furni<span>.</span></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni"
                aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsFurni">
                <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('show_order') }}">Order</a>
                    </li>
                    <li>

                    </li>
                </ul>

                <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-auto">


                    <li class="nav-item"><a class="nav-link" href="{{ url('/show_cart') }}"><img
                                src="{{ asset('dashboard/images/cart.svg') }}"></a></li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ asset('dashboard/images/user.svg') }}" class="user-icon">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end user-dropdown" aria-labelledby="userDropdown">
                                    <div class="user-info">
                                        <h3 class="user-name">{{ Auth::user()->name }}</h3>
                                    </div>
                                    <hr class="divider">
                                    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                        @csrf
                                        <button onclick="logout(event)" type="submit" class="dropdown-item logout-button"
                                            data-toggle="modal" data-target="#logoutModal">
                                            <img src="https://cdn1.iconfinder.com/data/icons/iconnice-vector-icon/29/Vector-icons_05-512.png"
                                                class="logout-icon" alt="Logout">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="btn btn-primary" id="logincss" href="{{ route('login') }}">Login</a>
                            </li>

                        @endauth
                    @endif
                </ul>
            </div>
        </div>

    </nav>

    <!-- End Header/Navigation -->

    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Order</h1>
                    </div>
                </div>
                <div class="col-lg-7">

                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    @include('sweetalert::alert')

    {{-- start body section --}}
    <div class="untree_co-section before-footer-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-10">
                    @if (count($order) > 0)
                        <p class="fs-6">Your Order</p>
                        @foreach ($order as $order)
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="/product/{{ $order->image }}" class="img-fluid rounded-start"
                                            alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            @if ($order->delivery_status == 'processing')
                                                <h5 class="card-title text-end">{{ $order->payment_status }} |
                                                    <span style="color: red">Processing</span>
                                                @elseif($order->delivery_status == 'Delivered')
                                                    <h5 class="card-title text-end">{{ $order->payment_status }} |
                                                        <span style="color: green">Delivered</span>
                                                    </h5>
                                                @else
                                                    <h5 class="card-title text-end">{{ $order->payment_status }} |
                                                        Order Cancelled
                                                    </h5>
                                            @endif
                                            <h5 class="card-title mt-3">{{ $order->product_title }}</h5>
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <p class="card-text">{{ $order->quantity }}x</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="fs-4 card-text text-end text-black">Rp.
                                                        {{ $order->price }}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="text-end">
                                                @if ($order->delivery_status == 'processing')
                                                    <form id="cancelForm"
                                                        action="{{ url('cancel_order', $order->id) }}" method="get">
                                                        <a onclick="confirmation(event)" href="#"
                                                            class="btn btn-danger">Cancel Order</a>
                                                    </form>
                                                @else
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12 text-center pt-5">
                            <span class="display-3 thankyou-icon text-primary">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart-check mb-5"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M11.354 5.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708 0z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                                    </path>
                                </svg>
                            </span>
                            <h2 class="display-3 text-black">No Order</h2>
                            <p class="lead mb-5">Let's make some order!</p>
                            <p><a href="{{ url('/') }}" class="btn btn-sm btn-outline-black">Back to shop</a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- End body section --}}

    <!-- Start Footer Section -->
    @include('home.footer')
    <!-- End Footer Section -->


    @include('home.script')

    <script>
        function logout(ev) {
            ev.preventDefault();
            var form = document.getElementById('logoutForm');
            var urlToRedirect = ev.currentTarget.getAttribute('href');
            console.log(urlToRedirect);
            swal({
                    title: "Are you sure?",
                    text: "You will be logged out!",
                    icon: "warning",
                    buttons: ['Cancel', 'Yes, log me out!'],
                    dangerMode: true,
                })
                .then((willLogout) => {
                    if (willLogout) {
                        form.submit();
                    }
                })
        }
    </script>

    <script>
        function confirmation(ev) {
            ev.preventDefault();
            var form = document.getElementById('cancelForm')
            var urlToRedirect = ev.currentTarget.getAttribute('href');
            console.log(urlToRedirect);
            swal({
                    title: "Are you sure to cancel this order?",
                    text: "You will not be able to revert this!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willCancel) => {
                    if (willCancel) {
                        form.submit();
                    }
                })
        }
    </script>


</body>

</html>
