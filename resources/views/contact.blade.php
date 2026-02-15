@extends('layouts.frontend')

@section('extra_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-red: #BE1E2D;
            --dark-blue: #002B49;
        }

        .contact-header {
            background: linear-gradient(135deg, var(--dark-blue) 0%, #054a7d 100%);
            padding: 80px 0;
            color: white;
            text-align: center;
        }

        .info-card {
            border: none;
            border-radius: 20px;
            transition: 0.3s;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            background: rgba(190, 30, 45, 0.1);
            color: var(--primary-red);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .contact-form-wrapper {
            background: white;
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
        }

        .form-control {
            padding: 12px 20px;
            border-radius: 10px;
            border: 1px solid #eee;
        }

        .form-control:focus {
            border-color: var(--primary-red);
            box-shadow: 0 0 0 0.25 red;
        }

        .btn-send {
            background: var(--primary-red);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            border: none;
            font-weight: 600;
            transition: 0.4s;
        }

        .btn-send:hover {
            background: #a01926;
            transform: scale(1.05);
            color: white;
        }
    </style>
@endsection

@section('content')
    <section class="contact-header">
        <div class="container">
            <h1 class="display-4 fw-bold">Get In Touch</h1>
            <p class="lead opacity-75">We are here to help the University community 24/7</p>
        </div>
    </section>

    <section class="py-5 mt-n5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="card info-card p-4 text-center d-flex flex-column align-items-center">
                        <div class="icon-circle"><i class="fa-solid fa-phone"></i></div>
                        <h5 class="fw-bold">Call Us</h5>
                        <p class="text-muted">+8801836115566</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card info-card p-4 text-center d-flex flex-column align-items-center">
                        <div class="icon-circle"><i class="fa-solid fa-envelope"></i></div>
                        <h5 class="fw-bold">Email Support</h5>
                        <p class="text-muted">niyd@gmail.com</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card info-card p-4 text-center d-flex flex-column align-items-center">
                        <div class="icon-circle"><i class="fa-solid fa-location-dot"></i></div>
                        <h5 class="fw-bold">Our Office</h5>
                        <p class="text-muted small">NIYD (National Institute of Youth Development)</p>
                    </div>
                </div>
            </div>

            <div class="row mt-5 pt-4">
                <div class="col-lg-6 mx-auto">
                    <div class="contact-form-wrapper">
                        <h3 class="fw-bold mb-4 text-center">Send us a Message</h3>
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('contact.send') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Your Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your full name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email/Phone</label>
                                <input type="text" name="contact_info" class="form-control"
                                    placeholder="How can we reach you?" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Message</label>
                                <textarea name="message" class="form-control" rows="4"
                                    placeholder="Type your message here..." required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-send w-100">Send Message <i
                                        class="fa-solid fa-paper-plane ms-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection