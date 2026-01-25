<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Blood Bank Portal')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-red: #dc3545;
            --dark-red: #a71d2a;
            --sidebar-bg: #1e2125;
            --body-bg: #f4f7f6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--body-bg);
            color: #333;
        }

        /* Navbar Styling */
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            z-index: 1030;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-red) !important;
        }

        /* Sidebar Styling */
        .sidebar {
            background-color: var(--sidebar-bg);
            min-height: calc(100vh - 56px);
            transition: all 0.3s;
            padding-top: 20px;
        }

        .sidebar h6 {
            color: #6c757d;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 10px 20px;
        }

        .nav-link {
            color: #ced4da;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: 0.3s;
            border-radius: 0;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: white;
        }

        .nav-link.active {
            background: var(--primary-red);
            color: white;
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        /* Card Styling */
        .card-ghost {
            border: none;
            border-radius: 12px;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            transition: transform 0.2s;
        }

        .card-ghost:hover {
            transform: translateY(-5px);
        }

        /* Custom Alert Style */
        .alert {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        main {
            padding: 30px;
        }

        footer {
            background: white;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="/">
                <i class="fa-solid fa-droplet me-1"></i> BLOOD BANK
            </a>
            
            <div class="ms-auto d-flex align-items-center">
                @if(auth()->check())
                    <span class="me-3 d-none d-md-inline text-muted small">
                        Welcome, <strong>{{ auth()->user()->name }}</strong>
                    </span>
                    <form method="POST" action="/logout" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger border-0">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="/login" class="btn btn-sm btn-light me-2 text-primary">Login</a>
                    <a href="/register" class="btn btn-sm btn-primary px-3 shadow-sm">Join Now</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-3 col-lg-2 p-0 sidebar d-none d-md-block shadow">
                <h6>Main Menu</h6>
                <nav class="nav flex-column">
                    @if(auth()->check())
                        <a href="/{{auth()->user()->role}}/dashboard" class="nav-link active">
                            <i class="fa-solid fa-gauge"></i> Dashboard
                        </a>

                        @if(auth()->user()->role == 'donor')
                            <h6>Donor Actions</h6>
                            <a href="/donor/appointment" class="nav-link">
                                <i class="fa-solid fa-calendar-check"></i> Book Appointment
                            </a>
                            <a href="/donor/history" class="nav-link">
                                <i class="fa-solid fa-clock-rotate-left"></i> History
                            </a>
                        @endif

                        @if(auth()->user()->role == 'hospital')
                            <h6>Hospital Services</h6>
                            <a href="/hospital/request" class="nav-link">
                                <i class="fa-solid fa-truck-medical"></i> Request Blood
                            </a>
                            <a href="/hospital/stock" class="nav-link">
                                <i class="fa-solid fa-box-archive"></i> Our Requests
                            </a>
                        @endif

                        @if(auth()->user()->role == 'manager')
                            <h6>Administration</h6>
                            <a href="/manager/inventory" class="nav-link">
                                <i class="fa-solid fa-warehouse"></i> Inventory Stock
                            </a>
                            <a href="/manager/requests" class="nav-link">
                                <i class="fa-solid fa-list-check"></i> Manage Requests
                            </a>
                            <a href="/manager/appointments" class="nav-link">
                                <i class="fa-solid fa-calendar-days"></i> Appointments
                            </a>
                            <a href="/manager/reports" class="nav-link">
                                <i class="fa-solid fa-chart-line"></i> Analytics Reports
                            </a>
                        @endif
                    @else
                        <a href="/register" class="nav-link">
                            <i class="fa-solid fa-user-plus"></i> Create Account
                        </a>
                        <a href="/login" class="nav-link">
                            <i class="fa-solid fa-sign-in-alt"></i> Sign In
                        </a>
                    @endif
                </nav>
            </aside>

            <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                @if(session('success') || isset($success))
                    <div class="alert alert-success alert-dismissible fade show mt-3">
                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') ?? $success }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-3">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="py-4">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <footer class="text-center py-4 text-muted small mt-auto">
        <div class="container">
            &copy; {{ date('Y') }} Blood Bank System &bull; Built for Community 🩸
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>