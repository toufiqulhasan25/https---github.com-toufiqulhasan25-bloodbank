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
            --body-bg: #f4f7f6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--body-bg);
            overflow-x: hidden;
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
            transition: all 0.3s ease;
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
            border-left: 4px solid transparent;
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
            padding: 10px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        /* Main Content */
        .main-wrapper {
            margin-left: 250px;
            padding: 30px;
            transition: all 0.3s ease;
        }

        /* Mobile View Fixes */
        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .top-nav,
            .main-wrapper {
                margin-left: 0;
            }
        }

        /* Role Badge Styling */
        .role-badge {
            font-size: 0.7rem;
            background: rgba(190, 30, 45, 0.1);
            color: var(--primary-red);
            padding: 2px 8px;
            border-radius: 50px;
            font-weight: 600;
        }
    </style>
    @yield('extra_css')
</head>

<body>

    <aside class="sidebar" id="sidebar">
        <div class="text-center py-4">
            {{-- লোগোতে হোম লিঙ্ক যোগ করা হয়েছে --}}
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" style="height: 40px; filter: brightness(0) invert(1);"
                    alt="Logo">
            </a>
        </div>

        <nav class="nav flex-column mt-3">
            <a href="/{{ auth()->user()->role }}/dashboard"
                class="nav-link {{ request()->is('*/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>

            {{-- DONOR MENU --}}
            @if(auth()->user()->role == 'donor')
                <h6>Donor Menu</h6>
                <a href="/donor/appointment" class="nav-link {{ request()->is('donor/appointment*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-check"></i> Appointment
                </a>
                <a href="/donor/history" class="nav-link {{ request()->is('donor/history*') ? 'active' : '' }}">
                    <i class="fa-solid fa-clock-rotate-left"></i> History
                </a>
            @endif

            {{-- HOSPITAL MENU --}}
            @if(auth()->user()->role == 'hospital')
                <h6>Medical Portal</h6>
                <a href="/hospital/request" class="nav-link {{ request()->is('hospital/request*') ? 'active' : '' }}">
                    <i class="fa-solid fa-truck-medical"></i> Request Blood
                </a>
                <a href="/hospital/history" class="nav-link {{ request()->is('hospital/history*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box-archive"></i> Request History
                </a>
                <a class="nav-link {{ request()->routeIs('hospital.patient.requests') ? 'active' : '' }}"
                    href="{{ route('hospital.patient.requests') }}">
                    <i class="fa-solid fa-bell me-2"></i> <span>Patient Requests</span>
                </a>
            @endif

            {{-- MANAGER MENU --}}
            @if(auth()->user()->role == 'manager')
                <h6>Administration</h6>
                <a href="/manager/inventory" class="nav-link {{ request()->is('manager/inventory*') ? 'active' : '' }}">
                    <i class="fa-solid fa-warehouse"></i> Inventory
                </a>
                <a href="/manager/requests" class="nav-link {{ request()->is('manager/requests*') ? 'active' : '' }}">
                    <i class="fa-solid fa-list-check"></i> Manage Orders
                </a>
                <a href="/manager/appointments"
                    class="nav-link {{ request()->is('manager/appointments*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-days"></i> Appointments
                </a>

                <a href="{{ route('admin.messages') }}"
                    class="nav-link {{ request()->is('admin/messages*') ? 'active' : '' }}">
                    <i class="fa-solid fa-envelope"></i> Contact Messages
                </a>
            @endif
        </nav>
    </aside>

    <header class="top-nav d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            {{-- মোবাইল টগল বাটন --}}
            <button class="btn btn-light d-md-none me-3 shadow-sm border" id="mobile-toggle">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h5 class="mb-0 fw-bold">@yield('page_title', 'Welcome')</h5>
        </div>

        <div class="dropdown">
            <button class="btn btn-white dropdown-toggle d-flex align-items-center gap-2 border shadow-sm" type="button"
                data-bs-toggle="dropdown">
                <div class="text-end d-none d-sm-block">
                    <p class="mb-0 fw-bold" style="font-size: 0.85rem; line-height: 1.2;">{{ auth()->user()->name }}</p>
                    <span class="role-badge">{{ ucfirst(auth()->user()->role) }}</span>
                </div>
                <i class="fa-solid fa-circle-user fs-3 text-secondary"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                <a href="{{ route(auth()->user()->role . '.profile.show') }}" class="dropdown-item">
                    <i class="fa-solid fa-user me-2"></i> Profile
                </a>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="/logout">
                        @csrf
                        <button class="dropdown-item py-2 text-danger"><i class="fa-solid fa-sign-out me-2"></i>
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

    <script>
        // মোবাইল টগল স্ক্রিপ্ট
        document.getElementById('mobile-toggle')?.addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // সাইডবারের বাইরে ক্লিক করলে মোবাইল ভিউতে বন্ধ হবে
        document.addEventListener('click', function (event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('mobile-toggle');
            if (window.innerWidth <= 768 && !sidebar.contains(event.target) && !toggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        });
    </script>
    @yield('extra_js')
</body>

</html>