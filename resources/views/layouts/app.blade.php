<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | NIYD Blood Bank</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-red: #BE1E2D;
            --sidebar-bg: #002B49;
            /* Vitalant-এর ডার্ক ব্লু থিম */
            --body-bg: #f4f7f6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--body-bg);
        }

        /* Sidebar Styling */
        .sidebar {
            background-color: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar h6 {
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 1px;
            padding: 20px 25px 10px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-left: 4px solid var(--primary-red);
        }

        /* Top Navbar */
        .top-nav {
            margin-left: 250px;
            background: #fff;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Main Content */
        .main-wrapper {
            margin-left: 250px;
            padding: 30px;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }

            .top-nav,
            .main-wrapper {
                margin-left: 0;
            }
        }

        .nav-link.active {
            background: rgba(190, 30, 45, 0.1) !important;
            color: var(--primary-red) !important;
            border-left: 4px solid var(--primary-red);
            font-weight: 600;
        }
    </style>
    @yield('extra_css')
</head>

<body>

    <aside class="sidebar">
        <div class="text-center py-4">
            <img src="{{ asset('images/logo.png') }}" style="height: 40px; filter: brightness(0) invert(1);">
        </div>

        <nav class="nav flex-column mt-3">
            <a href="/{{auth()->user()->role}}/dashboard"
                class="nav-link {{ request()->is('*/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>

            @if(auth()->user()->role == 'donor')
                <h6>Donor Menu</h6>
                <a href="/donor/appointment" class="nav-link {{ request()->is('*/appointment') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-check"></i> Appointment
                </a>
                <a href="/donor/history" class="nav-link {{ request()->is('*/history') ? 'active' : '' }}">
                    <i class="fa-solid fa-clock-rotate-left"></i> History
                </a>
            @endif

            @if(auth()->user()->role == 'hospital')
                <h6>Medical Portal</h6>
                <a href="/hospital/request" class="nav-link {{ request()->is('*/request') ? 'active' : '' }}">
                    <i class="fa-solid fa-truck-medical"></i> Request Blood
                </a>
                <a href="/hospital/stock" class="nav-link {{ request()->is('*/stock') ? 'active' : '' }}">
                    <i class="fa-solid fa-box-archive"></i> My Requests
                </a>
            @endif

            @if(auth()->user()->role == 'manager')
                <h6>Administration</h6>
                <a href="/manager/inventory" class="nav-link {{ request()->is('*/inventory') ? 'active' : '' }}">
                    <i class="fa-solid fa-warehouse"></i> Inventory
                </a>
                <a href="/manager/requests" class="nav-link {{ request()->is('*/requests') ? 'active' : '' }}">
                    <i class="fa-solid fa-list-check"></i> Manage Orders
                </a>
            @endif
        </nav>
    </aside>

    <header class="top-nav d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">@yield('page_title', 'Welcome')</h5>
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fa-solid fa-user-circle me-1"></i> {{ auth()->user()->name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li><a class="dropdown-item" href="/profile"><i class="fa-solid fa-user me-2"></i> Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="/logout">
                        @csrf
                        <button class="dropdown-item text-danger"><i class="fa-solid fa-sign-out me-2"></i>
                            Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main class="main-wrapper">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('extra_js')
</body>

</html>