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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('show_order') }}">Order</a>
                    </li>
                    <li>

                    </li>
                </ul>

                <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-auto">


                    <li class="nav-item active"><a class="nav-link" href="{{ url('/show_cart') }}"><img
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

    @include('sweetalert::alert')

    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Cart</h1>
                    </div>
                </div>
                <div class="col-lg-7">

                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    {{-- start body section --}}
    <div class="untree_co-section before-footer-section">
        <div class="container">
            <div class="row mb-5">
                <form class="col-md-12" method="post">
                    <div class="site-blocks-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">Image</th>
                                    <th class="product-name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-total">Total</th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $totalPrice = 0; ?>
                                @if (count($cart) > 0)
                                    @foreach ($cart as $cartItem)
                                        <?php $itemPrice = $cartItem->price / $cartItem->quantity; ?>
                                        <tr>
                                            <td class="product-thumbnail">
                                                <img src="/product/{{ $cartItem->image }}" alt="Image"
                                                    class="img-fluid">
                                            </td>
                                            <td class="product-name">
                                                <h2 class="h5 text-black">{{ $cartItem->product_title }}</h2>
                                            </td>
                                            <td>Rp. <strong
                                                    class="fs-4">{{ number_format($itemPrice, 0, ',', '.') }}</strong>
                                            </td>

                                            <td class="col-2">
                                                <div class="input-group">
                                                    <a href="{{ route('decreaseQuantity', ['cartId' => $cartItem->id]) }}"
                                                        class="btn btn-outline-secondary" type="button">-</a>
                                                    <input type="number" class="form-control text-center"
                                                        name="quantity" value="{{ $cartItem->quantity }}">
                                                    <a href="{{ route('increaseQuantity', ['cartId' => $cartItem->id]) }}"
                                                        class="btn btn-outline-secondary" type="button">+</a>
                                                </div>
                                            </td>

                                            <td>Rp. <strong
                                                    class="fs-4">{{ number_format($cartItem->price, 0, ',', '.') }}</strong>
                                            </td>
                                            <td><a onclick="confirmation(event)"
                                                    href="{{ url('remove_cart', $cartItem->id) }}"
                                                    class="btn btn-danger btn-sm">X</a></td>
                                        </tr>
                                        <?php $totalPrice = $totalPrice + $cartItem->price; ?>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="fs-4" colspan="12">No Product</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row justify-content-end">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12 text-right border-bottom mb-5">
                                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <span class="text-black">Total</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    @if (count($cart) > 0)
                                        <strong class="text-black">Rp.
                                            {{ number_format($totalPrice, 0, ',', '.') }}</strong>
                                    @else
                                        <strong>Rp. 0</strong>
                                    @endif
                                </div>
                            </div>

                            @if (count($cart) > 0)
                                <div class="row">
                                    <div class="col-6 col-md-6">
                                        <a onclick="checkout(event)" href="{{ url('cash_order') }}" class="btn btn-black btn-md">Cash On
                                            Delivery</a>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <a href="{{ url('stripe', $totalPrice) }}" class="btn btn-primary btn-md">Pay
                                            Using Card</a>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-6 col-md-6">
                                        <a href="{{ url('cash_order') }}" class="btn btn-black btn-md disabled">Cash
                                            On
                                            Delivery</a>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <a href="{{ url('stripe', $totalPrice) }}"
                                            class="btn btn-primary btn-md disabled">Pay
                                            Using Card</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
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
        function confirmation(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href');
            console.log(urlToRedirect);
            swal({
                    title: "Are you sure to remove this product?",
                    text: "You will not be able to revert this!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willCancel) => {
                    if (willCancel) {
                        window.location.href = urlToRedirect;
                    }
                })
        }
    </script>

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
        function checkout(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href');
            console.log(urlToRedirect);
            swal({
                    title: "Ready To Checkout?",
                    text: "You will not be able to revert this!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willCancel) => {
                    if (willCancel) {
                        window.location.href = urlToRedirect;
                    }
                })
        }
    </script>
</body>

</html>
