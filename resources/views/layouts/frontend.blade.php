<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'NIYD Blood Bank')</title>

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary-color: #BE1E2D;
            --dark-blue: #002B49;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--dark-blue);
            margin: 0;
            padding: 0;
            background-color: #fff; /* Background fixed */
        }

        .navbar {
            background: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 10px 0;
        }

        .navbar-brand img { height: 50px; }

        .nav-link {
            font-weight: 600;
            color: var(--dark-blue) !important;
            margin: 0 10px;
        }

        .btn-join {
            background: var(--primary-color);
            color: white !important;
            padding: 8px 25px;
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            border: none;
            transition: 0.3s;
        }

        .btn-join:hover {
            background: #961824;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(190, 30, 45, 0.3);
        }

        main { min-height: 70vh; } /* Content area visibility fix */
    </style>
    @yield('extra_css')
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="NIYD Logo" onerror="this.src='https://via.placeholder.com/150x50?text=NIYD+Logo'">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('find.blood') }}">Find Blood</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/donate-info') }}">Donate</a></li>

                    @guest
                        <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                        <li class="nav-item"><a href="/register" class="btn btn-join ms-lg-3">Join Now</a></li>
                    @endguest

                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-circle-user fs-4 me-2"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->role == 'hospital')
                                    <li><a class="dropdown-item" href="{{ url('/hospital/dashboard') }}"><i class="fa-solid fa-gauge me-2"></i>Dashboard</a></li>
                                @elseif(Auth::user()->role == 'donor')
                                    <li><a class="dropdown-item" href="{{ url('/donor/dashboard') }}"><i class="fa-solid fa-gauge me-2"></i>Dashboard</a></li>
                                @elseif(Auth::user()->role == 'manager')
                                    <li><a class="dropdown-item" href="{{ route('manager.dashboard') }}"><i class="fa-solid fa-gauge me-2"></i>Dashboard</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ url('/logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="py-5 bg-dark text-white mt-5">
        <div class="container">
            <div class="row g-4 text-center text-md-start">
                <div class="col-lg-4">
                    <h4 class="text-danger fw-bold">NIYD Blood Bank</h4>
                    <p class="opacity-75 small">Connecting students, teachers, and staff for a noble cause. Your one drop can save a life.</p>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-4">Quick Links</h5>
                    <ul class="list-unstyled opacity-75 small">
                        <li><a href="/" class="text-white text-decoration-none">Home</a></li>
                        <li><a href="/find-blood" class="text-white text-decoration-none">Find Donors</a></li>
                        <li><a href="/register" class="text-white text-decoration-none">Become a Hero</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-4">Contact</h5>
                    <p class="small opacity-75"><i class="fa-solid fa-envelope me-2"></i> support@niydbloodbank.com</p>
                    <p class="small opacity-75"><i class="fa-solid fa-location-dot me-2"></i> NIYD Campus Center</p>
                </div>
            </div>
            <hr class="my-4 opacity-25">
            <p class="text-center opacity-50 small mb-0">© {{ date('Y') }} NIYD Blood Bank. Built with ❤️</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('extra_js')
</body>
</html>