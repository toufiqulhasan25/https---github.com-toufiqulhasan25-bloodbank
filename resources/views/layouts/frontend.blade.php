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
        }

        .navbar {
            background: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 15px 0;
        }

        .navbar-brand img {
            height: 50px;
        }

        .nav-link {
            font-weight: 600;
            color: var(--dark-blue) !important;
            margin: 0 15px;
        }

        .btn-join {
            background: var(--primary-color);
            color: white !important;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            border: none;
            font-size: 14px;
        }

        .btn-join:hover {
            background: #961824;
            transform: translateY(-2px);
            color: white !important;
            border-color: #BE1E2D !important;
        }

        footer {
            background: #111;
            color: white;
            padding: 40px 0;
            margin-top: 60px;
        }
    </style>
    @yield('extra_css')
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="{{ asset('images/logo.png') }}" alt="Logo"></a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('find.blood') }}">Find Blood</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/donate-info') }}">Donate</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                    <li class="nav-item"><a href="/register" class="btn btn-join">Join Now</a></li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="py-5 bg-dark text-white mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <img src="{{ asset('images/logo.png') }}" class="mb-4"
                        style="height: 45px; filter: brightness(0) invert(1);">
                    <p class="opacity-75 small">
                        NIYD Blood Bank is a dedicated platform for students, teachers, and staff to bridge the gap
                        between blood donors and those in need. Join our life-saving community today.
                    </p>
                    <div class="mt-4">
                        <a href="#" class="text-white me-3 opacity-75 hover-danger"><i
                                class="fa-brands fa-facebook fs-5"></i></a>
                        <a href="#" class="text-white me-3 opacity-75 hover-danger"><i
                                class="fa-brands fa-twitter fs-5"></i></a>
                        <a href="#" class="text-white me-3 opacity-75 hover-danger"><i
                                class="fa-brands fa-instagram fs-5"></i></a>
                        <a href="#" class="text-white opacity-75 hover-danger"><i
                                class="fa-brands fa-linkedin fs-5"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4">
                    <h5 class="fw-bold mb-4">Quick Links</h5>
                    <ul class="list-unstyled opacity-75 small">
                        <li class="mb-2"><a href="/" class="text-white text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="/find-blood" class="text-white text-decoration-none">Find Donors</a>
                        </li>
                        <li class="mb-2"><a href="/register" class="text-white text-decoration-none">Become a Donor</a>
                        </li>
                        <li class="mb-2"><a href="/hospitals" class="text-white text-decoration-none">Hospitals</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-4">
                    <h5 class="fw-bold mb-4">Support</h5>
                    <ul class="list-unstyled opacity-75 small">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">FAQs</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Privacy Policy</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Terms of Service</a></li>
                        <li class="mb-2"><a href="/contact" class="text-white text-decoration-none">Contact Us</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-4">
                    <h5 class="fw-bold mb-4">Contact Us</h5>
                    <ul class="list-unstyled opacity-75 small">
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fa-solid fa-location-dot me-3 text-danger"></i>
                            <span>Your Campus Address, City, Country</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fa-solid fa-phone me-3 text-danger"></i>
                            <span>+880 1234 567 890</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fa-solid fa-envelope me-3 text-danger"></i>
                            <span>support@niydbloodbank.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="my-5 opacity-25">

            <div class="text-center">
                <p class="opacity-50 small mb-0">© {{ date('Y') }} NIYD Blood Bank Management System. Built with ❤️ for
                    the Community.</p>
            </div>
        </div>
    </footer>

    <style>
        .hover-danger:hover {
            color: #BE1E2D !important;
            opacity: 1 !important;
            transition: 0.3s;
        }

        footer ul li a:hover {
            color: #BE1E2D !important;
            padding-left: 5px;
            transition: 0.3s;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>