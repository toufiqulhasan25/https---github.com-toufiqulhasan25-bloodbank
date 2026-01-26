@extends('layouts.frontend')

@section('extra_css')
    <style>
        /* Hero Section Fix */
        .hero {
            background: linear-gradient(rgba(0, 43, 73, 0.8), rgba(0, 43, 73, 0.8)),
                url('https://images.unsplash.com/photo-1615461066841-6116ecaaba7f?q=80&w=2000');
            background-size: cover;
            background-position: center;
            padding: 120px 0;
            color: white;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
        }

        /* Action Box Fix */
        .action-box {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            margin-top: -60px;
            position: relative;
            z-index: 5;
        }

        .stats-num {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
        }

        .stats-label {
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            color: #666;
        }

        /* Buttons */
        .btn-vital {
            background: var(--primary-color);
            color: white !important;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-vital:hover {
            opacity: 0.9;
            transform: scale(1.05);
            color: black !important;
            border-color: #BE1E2D !important;

        }

        /* Portal Cards Design */
        .card-portal {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid #eee !important;
            display: flex;
            flex-direction: column;
            /* বাটন নিচে রাখার জন্য */
            height: 100%;
        }

        .card-portal:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(190, 30, 45, 0.1) !important;
            border-color: #BE1E2D !important;
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            background: #fdf2f2;
            color: #BE1E2D;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            border-radius: 50%;
            margin: 0 auto 20px;
            transition: 0.3s;
        }

        .card-portal:hover .icon-circle {
            background: #BE1E2D;
            color: white;
        }

        .color-dark-blue {
            color: #002B49;
        }

        /* বাটন সিরিয়াল ঠিক করার জন্য */
        .card-body-content {
            flex-grow: 1;
            /* এটি সব খালি জায়গা দখল করবে */
            display: flex;
            flex-direction: column;
        }
    </style>
@endsection

@section('content')
    <header class="hero">
        <div class="container">
            <h1>Because of You, <br> <span class="text-danger">Life Goes On.</span></h1>
            <p class="lead">Every donation counts. Join our community of students, teachers, and staff.</p>
            <div class="mt-4">
                <a href="/register" class="btn btn-vital">Donate Blood Now</a>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="action-box text-center">
            <div class="row">
                <div class="col-md-4 border-end">
                    <p class="stats-label">Lives Saved</p>
                    <h2 class="stats-num">45,200+</h2>
                </div>
                <div class="col-md-4 border-end">
                    <p class="stats-label">Active Donors</p>
                    <h2 class="stats-num">12,500+</h2>
                </div>
                <div class="col-md-4">
                    <p class="stats-label">Hospitals Linked</p>
                    <h2 class="stats-num">320+</h2>
                </div>
            </div>
        </div>
    </div>

    <section class="container py-5 mt-5 text-center">
        <div class="mb-5">
            <h6 class="text-danger fw-bold text-uppercase tracking-wider" style="letter-spacing: 2px;">Our Network</h6>
            <h2 class="display-6 fw-bold color-dark-blue">How Can We Help You Today?</h2>
            <div class="mx-auto bg-danger mt-2" style="height: 4px; width: 60px; border-radius: 10px;"></div>
        </div>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="card-portal p-5 border rounded-4 shadow-sm bg-white">
                    <div class="card-body-content">
                        <div class="icon-circle">
                            <i class="fa-solid fa-hand-holding-droplet"></i>
                        </div>
                        <h4 class="fw-bold mb-3">For Donors</h4>
                        <p class="text-muted small">Register as a donor, track your history, and receive emergency alerts.
                        </p>
                        <div class="mt-auto">
                            <a href="/register" class="btn btn-vital btn-sm px-4">Become a Hero</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-portal p-5 border rounded-4 shadow-sm bg-white">
                    <div class="card-body-content">
                        <div class="icon-circle">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Find Blood</h4>
                        <p class="text-muted small">Search for available donors near your location instantly.</p>
                        <div class="mt-auto">
                            <a href="/find-blood"
                                class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-bold shadow-sm">Search Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-portal p-5 border rounded-4 shadow-sm bg-white">
                    <div class="card-body-content">
                        <div class="icon-circle">
                            <i class="fa-solid fa-hospital"></i>
                        </div>
                        <h4 class="fw-bold mb-3">For Hospitals</h4>
                        <p class="text-muted small">Request bulk blood units and manage real-time inventory.</p>
                        <div class="mt-auto">
                            <a href="/hospitals-info"
                                class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-bold shadow-sm">Request Units</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-portal p-5 border rounded-4 shadow-sm bg-white">
                    <div class="card-body-content">
                        <div class="icon-circle">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <h4 class="fw-bold mb-3">For Staff</h4>
                        <p class="text-muted small">Access system tools for donor verification and monitoring.</p>
                        <div class="mt-auto">
                            <a href="/login"
                                class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-bold shadow-sm">Portal Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="https://images.unsplash.com/photo-1615461065624-21b562ee5566?q=80&w=1000"
                        class="img-fluid rounded-4 shadow" alt="Blood Donation Eligibility">
                </div>
                <div class="col-md-6 ps-md-5">
                    <h6 class="text-danger fw-bold text-uppercase">Check Your Eligibility</h6>
                    <h2 class="fw-bold mb-4">Can You Donate Blood Today?</h2>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="fa-solid fa-circle-check text-success me-2"></i> Age: 18 to 60 years</li>
                        <li class="mb-3"><i class="fa-solid fa-circle-check text-success me-2"></i> Weight: At least 50 kg
                        </li>
                        <li class="mb-3"><i class="fa-solid fa-circle-check text-success me-2"></i> No major health issues
                            recently</li>
                        <li class="mb-3"><i class="fa-solid fa-circle-check text-success me-2"></i> Last donation: 3-4
                            months ago</li>
                    </ul>
                    <a href="/donate-info" class="btn btn-outline-danger px-4 rounded-pill fw-bold mt-3">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light py-5">
        <div class="container text-center py-4">
            <h2 class="fw-bold mb-5">Why Donate with NIYD?</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                        <i class="fa-solid fa-id-card-clip fs-1 text-danger mb-3"></i>
                        <h5>Health Card</h5>
                        <p class="text-muted small">Get your personalized donor health card instantly.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                        <i class="fa-solid fa-bell fs-1 text-danger mb-3"></i>
                        <h5>Instant Alerts</h5>
                        <p class="text-muted small">Get alerts when someone needs your blood group.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                        <i class="fa-solid fa-shield-heart fs-1 text-danger mb-3"></i>
                        <h5>Safe & Secure</h5>
                        <p class="text-muted small">We ensure the highest safety standards for you.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                        <i class="fa-solid fa-users-line fs-1 text-danger mb-3"></i>
                        <h5>Community</h5>
                        <p class="text-muted small">A network of teachers, students, and staff.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="text-white p-5 rounded-5 text-center shadow-lg"
                style="background: linear-gradient(45deg, #002B49, #BE1E2D);">
                <h2 class="display-6 fw-bold mb-3">Ready to Save a Life?</h2>
                <p class="lead opacity-75 mb-4">Register today and become a hero in our community. Every drop counts.</p>
                <a href="/register" class="btn btn-light btn-lg px-5 rounded-pill fw-bold text-danger">Register Now</a>
            </div>
        </div>
    </section>
@endsection