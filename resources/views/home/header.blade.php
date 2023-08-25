<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Furni<span>.</span></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni"
            aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
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
