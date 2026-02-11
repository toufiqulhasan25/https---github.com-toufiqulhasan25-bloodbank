@extends('layouts.frontend')

@section('title', 'Blood Donation Guide | NIYD Blood Bank')

@section('extra_css')
<style>
    :root { 
        --primary-red: #BE1E2D; 
        --deep-navy: #002B49; 
        --soft-bg: #f8f9fa;
    }
    
    .info-hero {
        background: linear-gradient(rgba(0,43,73,0.85), rgba(0,43,73,0.85)), url('{{ asset("images/bg.png") }}');
        background-size: cover;
        background-position: center;
        padding: 120px 0;
        color: white;
        border-radius: 0 0 50px 50px;
    }

    .process-card {
        border: none;
        border-radius: 25px;
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        background: #fff;
    }
    .process-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }

    .icon-circle {
        width: 80px;
        height: 80px;
        background: #fff1f2;
        color: var(--primary-red);
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 25px;
        transition: 0.3s;
    }
    .process-card:hover .icon-circle {
        background: var(--primary-red);
        color: white;
    }

    .eligibility-box {
        background: white;
        padding: 40px;
        border-radius: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        border: 1px solid #eee;
    }

    .benefit-item {
        padding: 15px;
        border-radius: 15px;
        background: #f8f9fa;
        margin-bottom: 15px;
        border-left: 5px solid var(--primary-red);
    }
</style>
@endsection

@section('content')
<section class="info-hero text-center">
    <div class="container" data-aos="zoom-in">
        <h1 class="display-4 fw-bold mb-3">Be a Hero – Save a Life</h1>
        <p class="lead mb-5 opacity-90 mx-auto" style="max-width: 700px;">
            Blood donation is a noble act that brings people together. Your one donation can provide a second chance at life for up to three people.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ url('/register') }}" class="btn btn-danger btn-lg rounded-pill px-5 shadow-sm fw-bold border-0" style="background-color: var(--primary-red);">
                Register as a Donor
            </a>
            <a href="#learn-more" class="btn btn-outline-light btn-lg rounded-pill px-5">
                Learn the Process
            </a>
        </div>
    </div>
</section>

<div class="container py-5" id="learn-more">
    <div class="text-center mb-5">
        <h2 class="fw-bold" style="color: var(--deep-navy);">How It Works</h2>
        <p class="text-muted">The simple three-step process to becoming a life-saver.</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="process-card p-4 shadow-sm border text-center">
                <div class="icon-circle mx-auto"><i class="fas fa-id-card"></i></div>
                <h4 class="fw-bold">1. Registration</h4>
                <p class="text-muted">Join our community by creating an account. Provide your blood group and location so those in need can find you easily.</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="process-card p-4 shadow-sm border text-center">
                <div class="icon-circle mx-auto"><i class="fas fa-stethoscope"></i></div>
                <h4 class="fw-bold">2. Health Screening</h4>
                <p class="text-muted">Before donation, a brief medical check-up ensures you are healthy and fit to donate without any risk to your health.</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="process-card p-4 shadow-sm border text-center">
                <div class="icon-circle mx-auto"><i class="fas fa-tint"></i></div>
                <h4 class="fw-bold">3. Donation & Joy</h4>
                <p class="text-muted">Actual donation takes only 10 minutes. Afterward, enjoy some snacks and the incredible feeling of saving a life!</p>
            </div>
        </div>
    </div>

    <div class="eligibility-box mb-5" data-aos="fade-up">
        <div class="row align-items-center">
            <div class="col-lg-5 text-center text-lg-start mb-4 mb-lg-0">
                <h2 class="fw-bold mb-3">Who Can Give Blood?</h2>
                <p class="text-muted mb-4">Most people can give blood if they are in good health. Here are the basic requirements:</p>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 border rounded-3 text-center">
                            <h3 class="text-danger fw-bold mb-0">18-60</h3>
                            <small class="text-muted">Age (Years)</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded-3 text-center">
                            <h3 class="text-danger fw-bold mb-0">50kg+</h3>
                            <small class="text-muted">Min Weight</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="row g-4 text-center">
                    <div class="col-sm-6">
                        <div class="p-4 bg-light rounded-4 h-100">
                            <i class="fa-solid fa-notes-medical text-danger fs-2 mb-3"></i>
                            <h6 class="fw-bold">Overall Health</h6>
                            <p class="small text-muted mb-0">Must be feeling well and not have any chronic infections.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-4 bg-light rounded-4 h-100">
                            <i class="fa-solid fa-hourglass-half text-danger fs-2 mb-3"></i>
                            <h6 class="fw-bold">Interval</h6>
                            <p class="small text-muted mb-0">At least 90 days gap between two blood donations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row align-items-center g-5 py-4">
        <div class="col-lg-6 order-2 order-lg-1" data-aos="fade-right">
            <img src="https://img.freepik.com/free-vector/hand-drawn-blood-donation-concept_23-2148474258.jpg" alt="Blood Donation Benefits" class="img-fluid rounded-5 shadow">
        </div>
        <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left">
            <h2 class="fw-bold mb-4">Benefits of Donating Blood</h2>
            <div class="benefit-item shadow-sm">
                <h6 class="fw-bold mb-1">Free Health Check-up</h6>
                <p class="small text-muted mb-0">Each donor gets a mini-physical check including blood pressure and hemoglobin levels.</p>
            </div>
            <div class="benefit-item shadow-sm">
                <h6 class="fw-bold mb-1">Improved Heart Health</h6>
                <p class="small text-muted mb-0">Regular donation helps balance iron levels in the body, reducing the risk of heart disease.</p>
            </div>
            <div class="benefit-item shadow-sm">
                <h6 class="fw-bold mb-1">Sense of Pride</h6>
                <p class="small text-muted mb-0">The psychological benefit of knowing you've helped someone in need is immeasurable.</p>
            </div>
        </div>
    </div>

    <div class="mt-5 p-5 rounded-5 text-center text-white" style="background: var(--deep-navy);" data-aos="zoom-in">
        <h2 class="fw-bold mb-3">Ready to make a difference?</h2>
        <p class="mb-4 opacity-75">Your small contribution is a big hope for someone else.</p>
        <a href="{{ url('/register') }}" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-navy">
            Join the Community Now
        </a>
    </div>
</div>
@endsection

@section('extra_js')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });
</script>
@endsection