@extends('layouts.frontend')

@section('extra_css')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-red: #BE1E2D;
            --dark-blue: #002B49;
            --soft-bg: #f8f9fa;
        }

        /* Professional Hero Section */
        .hero {
            position: relative;
            background: linear-gradient(135deg, var(--dark-blue) 0%, #054a7d 100%);
            padding: 120px 0 180px;
            color: white;
            overflow: hidden;
        }

        .hero::after {
            content: "";
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 100px;
            background: white;
            clip-path: polygon(0 100%, 100% 100%, 100% 0);
        }

        .hero-img-wrapper img {
            filter: drop-shadow(0 20px 50px rgba(0,0,0,0.3));
            animation: floating 4s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        /* Stat Card Modernized */
        .stat-card {
            border: none;
            border-top: 4px solid var(--primary-red);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            border-radius: 15px !important;
        }
        .stat-card:hover {
            background: var(--primary-red) !important;
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(190, 30, 45, 0.2) !important;
        }
        .stat-card:hover h2, .stat-card:hover p { 
            color: white !important; 
        }

        /* Step Card Style */
        .step-card {
            border: none;
            border-radius: 20px;
            transition: 0.3s;
            background: #fff;
        }
        .step-card .icon-box {
            width: 75px;
            height: 75px;
            background: var(--soft-bg);
            color: var(--primary-red);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 25px;
            transition: 0.4s;
        }
        .step-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
        }
        .step-card:hover .icon-box {
            background: var(--primary-red);
            color: #fff;
            transform: rotateY(360deg);
        }

        /* Blood Compatibility Table */
        .table-compat {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .table-compat thead {
            background: var(--primary-red);
            color: white;
        }
        .table-compat th, .table-compat td {
            padding: 15px;
            vertical-align: middle;
        }
        .compat-img {
            max-height: 380px;
            width: 100%;
            object-fit: contain;
        }

        /* FAQ Layout Improvement */
        .accordion-item {
            margin-bottom: 15px;
            border-radius: 12px !important;
            border: 1px solid #eee !important;
        }
        .accordion-button {
            border-radius: 12px !important;
            padding: 20px;
        }
        .accordion-button:not(.collapsed) {
            background-color: var(--primary-red);
            color: white;
            box-shadow: none;
        }

        .btn-vital {
            background: var(--primary-red);
            color: white !important;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 700;
            transition: 0.4s;
            box-shadow: 0 8px 20px rgba(190, 30, 45, 0.25);
            border: none;
        }
        .btn-vital:hover {
            transform: translateY(-3px);
            background: #a01926;
            box-shadow: 0 12px 25px rgba(190, 30, 45, 0.35);
        }

        .reviewer-img {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--soft-bg);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
@endsection

@section('content')

    <header class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 text-center text-lg-start" data-aos="fade-right">
                    <div class="badge bg-danger mb-3 px-3 py-2 rounded-pill shadow-sm">#1 Blood Bank for University Community</div>
                    <h1 class="display-3 fw-bold mb-4">Your Blood Can <br><span class="text-info">Save A Hero.</span></h1>
                    <p class="lead mb-5 opacity-90">Join the largest network of students, teachers, and staff donors. Be the reason for someone's heartbeat today.</p>
                    
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                        @auth
                            <a href="/dashboard" class="btn btn-vital btn-lg">User Dashboard</a>
                        @else
                            <a href="/register" class="btn btn-vital btn-lg">Register as Donor</a>
                            <a href="/find-blood" class="btn btn-outline-light btn-lg rounded-pill px-5">Search Blood</a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block hero-img-wrapper" data-aos="zoom-in">
                    <img src="{{ asset('images/hero-illustration.png') }}" alt="Blood Donation Hero" class="img-fluid">
                </div>
            </div>
        </div>
    </header>

    <div class="container mt-n5 position-relative" style="z-index: 5;">
        <div class="row g-4 text-center">
            @php 
                $stats = [
                    ['5,000+', 'ACTIVE DONORS', '100'],
                    ['1,200+', 'LIVES SAVED', '200'],
                    ['24/7', 'EMERGENCY HELP', '300'],
                    ['100%', 'FREE TO USE', '400']
                ];
            @endphp
            @foreach($stats as $stat)
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="{{ $stat[2] }}">
                <div class="bg-white p-lg-4 p-3 rounded-4 shadow-sm stat-card">
                    <h2 class="fw-bold text-danger mb-1">{{ $stat[0] }}</h2>
                    <p class="text-muted mb-0 fw-bold small">{{ $stat[1] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    

    <section class="py-5 mt-5">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h6 class="text-danger fw-bold text-uppercase tracking-wider">Simple Process</h6>
                <h2 class="fw-bold display-5">How It Works</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 p-4 shadow-sm step-card text-center">
                        <div class="icon-box mx-auto"><i class="fa-solid fa-user-plus"></i></div>
                        <h4 class="fw-bold">Register</h4>
                        <p class="text-muted">Create your profile as a student, teacher, or staff. It takes only 2 minutes.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 p-4 shadow-sm step-card text-center border-danger border-1">
                        <div class="icon-box mx-auto bg-danger text-white"><i class="fa-solid fa-magnifying-glass"></i></div>
                        <h4 class="fw-bold">Search or Request</h4>
                        <p class="text-muted">Find matching donors near your location or post an urgent blood request.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 p-4 shadow-sm step-card text-center">
                        <div class="icon-box mx-auto"><i class="fa-solid fa-hand-holding-heart"></i></div>
                        <h4 class="fw-bold">Save Lives</h4>
                        <p class="text-muted">Connect with the donor and help someone in their critical moment.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h6 class="text-danger fw-bold text-uppercase mb-3">Knowledge Base</h6>
                    <h2 class="fw-bold mb-4">Blood Group Compatibility</h2>
                    <p class="text-muted mb-4">Understanding which blood type you can receive or donate is crucial during emergencies. Check the quick guide below.</p>
                    
                    <div class="table-responsive">
                        <table class="table table-compat text-center mb-0">
                            <thead>
                                <tr>
                                    <th>Group</th>
                                    <th>Can Give To</th>
                                    <th>Can Receive From</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-danger">O+</td>
                                    <td>O+, A+, B+, AB+</td>
                                    <td>O+, O-</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-danger">A+</td>
                                    <td>A+, AB+</td>
                                    <td>A+, A-, O+, O-</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-danger">AB+</td>
                                    <td>AB+ Only</td>
                                    <td>Universal Receiver</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <img src="{{ asset('images/compatibility-infographic.png') }}" class="img-fluid rounded-4 shadow-lg compat-img" alt="Compatibility">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold display-6">Community Testimonials</h2>
                <p class="text-muted">What our donors and receivers are saying.</p>
            </div>
            <div class="row g-4">
                @php
                    $testimonials = [
                        ['user1.jpg', 'Tanvir Rahman', 'CSE Student', '"Finding a donor was so stressful until I used this portal. I found a match within 15 minutes."'],
                        ['user2.jpg', 'Nusrat Jahan', 'Assistant Professor', '"As a teacher, I feel proud to be a part of this lifeline. The process is very secure."'],
                        ['user3.jpg', 'Dr. Ariful Islam', 'Medical Officer', '"This system has bridged the gap between blood seekers and donors. Truly a lifesaver."']
                    ];
                @endphp
                @foreach($testimonials as $index => $item)
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="{{ ($index+1)*100 }}">
                    <div class="bg-white p-4 rounded-4 shadow-sm h-100 border-start border-danger border-4">
                        <div class="mb-3 text-warning">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        </div>
                        <p class="text-muted italic">{{ $item[3] }}</p>
                        <div class="d-flex align-items-center mt-4">
                            <img src="{{ asset('images/'.$item[0]) }}" class="reviewer-img me-3" alt="User">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $item[1] }}</h6>
                                <small class="text-danger">{{ $item[2] }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-5" data-aos="fade-right">
                    <h6 class="text-danger fw-bold text-uppercase">Support</h6>
                    <h2 class="fw-bold mb-4">Frequently Asked Questions</h2>
                    <p class="text-muted">Have more questions? Feel free to contact our 24/7 support team for any assistance regarding blood donation.</p>
                    <a href="/contact" class="btn btn-outline-danger rounded-pill px-4 mt-2">Contact Support</a>
                </div>
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="accordion shadow-sm overflow-hidden" id="faqAccordion">
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Who can become a donor?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Any healthy student, teacher, or staff member aged 18-60 with a weight over 50kg can register as a donor.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Is my personal data safe?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Yes, we use advanced encryption. Your contact details are only visible to verified blood seekers and university administration.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    How often can I donate blood?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Usually, you can donate blood every 3 to 4 months (90-120 days) depending on your health condition and gender.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5 my-5">
        <div class="bg-dark text-white p-lg-5 p-4 rounded-5 shadow-lg position-relative overflow-hidden" data-aos="flip-up">
            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-lg-8 text-center text-lg-start">
                    <h2 class="display-5 fw-bold mb-3">Ready to save a life?</h2>
                    <p class="lead opacity-75 mb-lg-0">Join thousands of heroes in our university community today.</p>
                </div>
                <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                    <a href="/register" class="btn btn-vital btn-lg px-5">Join Now <i class="fa-solid fa-arrow-right ms-2"></i></a>
                </div>
            </div>
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(190, 30, 45, 0.1); border-radius: 50%;"></div>
        </div>
    </section>

@endsection

@section('extra_js')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ 
            duration: 1000, 
            once: true,
            offset: 100 
        });
    </script>
@endsection