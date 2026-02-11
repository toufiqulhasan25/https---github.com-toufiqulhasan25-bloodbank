<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Join NIYD | Become a Lifesaver</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary-color: #BE1E2D;
            --dark-blue: #002B49;
            --light-bg: #F4F7F9;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--light-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .reg-card {
            background: #fff;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 1000px;
            width: 95%;
            display: flex;
            position: relative;
        }

        .reg-side-info {
            background: var(--dark-blue);
            color: white;
            padding: 60px;
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .reg-form-area {
            padding: 60px;
            width: 60%;
            position: relative;
        }

        .btn-home-corner {
            position: absolute;
            top: 30px;
            right: 30px;
            background: #f8f9fa;
            color: var(--dark-blue);
            border-radius: 50px;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid #eee;
            transition: 0.3s;
            z-index: 10;
        }

        .btn-home-corner:hover {
            background: var(--primary-color);
            color: #fff;
            box-shadow: 0 4px 12px rgba(190, 30, 45, 0.2);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-blue);
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            margin-bottom: 5px;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(190, 30, 45, 0.1);
        }

        .btn-register {
            background: var(--primary-color);
            color: white;
            width: 100%;
            padding: 15px;
            border-radius: 50px;
            font-weight: 700;
            border: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
            margin-top: 20px;
        }

        .btn-register:hover {
            background: #961824;
            transform: translateY(-2px);
        }

        .error-text {
            color: var(--primary-color);
            font-size: 12px;
            margin-bottom: 10px;
            display: block;
        }

        @media (max-width: 768px) {
            .reg-card {
                flex-direction: column;
            }

            .reg-side-info,
            .reg-form-area {
                width: 100%;
                padding: 30px;
            }

            .btn-home-corner {
                top: 15px;
                right: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="reg-card shadow-lg">
        <div class="reg-side-info d-none d-md-flex">
            <a href="/"><img src="{{ asset('images/logo.png') }}" alt="Logo"
                    style="height: 40px; filter: brightness(0) invert(1); margin-bottom: 40px;"></a>
            <h2 class="fw-bold mb-4">Start Your Journey as a Hero.</h2>
            <p class="opacity-75">Join our network of donors and hospitals dedicated to saving lives.</p>
            <ul class="list-unstyled mt-4">
                <li class="mb-3"><i class="fa-solid fa-check-circle me-2 text-danger"></i> Track your donations</li>
                <li class="mb-3"><i class="fa-solid fa-check-circle me-2 text-danger"></i> Connect with Hospitals</li>
                <li class="mb-3"><i class="fa-solid fa-check-circle me-2 text-danger"></i> Manage Blood Inventory</li>
            </ul>
        </div>

        <div class="reg-form-area">
            <a href="/" class="btn-home-corner">
                <i class="fa-solid fa-house me-1"></i> Home
            </a>

            <h3 class="fw-bold mb-1 mt-2">Create Account</h3>
            <p class="text-muted mb-4">Already have an account? <a href="{{ url('/login') }}"
                    class="text-danger fw-bold text-decoration-none">Login</a></p>

            <form action="{{ url('/register') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label" id="nameLabel">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="John Doe" value="{{ old('name') }}" required>
                        @error('name') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="john@example.com" value="{{ old('email') }}" required>
                        @error('email') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Who Are You?</label>
                        <select name="role" id="userRole" class="form-select @error('role') is-invalid @enderror"
                            required onchange="toggleFields()">
                            <option value="donor" {{ old('role') == 'donor' ? 'selected' : '' }}>Individual Donor</option>
                            <option value="hospital" {{ old('role') == 'hospital' ? 'selected' : '' }}>Hospital / Medical
                                Center</option>
                        </select>
                        @error('role') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row" id="donorSpecificFields">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror"
                            value="{{ old('dob') }}">
                        @error('dob') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Last Donation Date</label>
                        <input type="date" name="last_donation_date"
                            class="form-control @error('last_donation_date') is-invalid @enderror"
                            value="{{ old('last_donation_date') }}">
                        <small class="text-muted" style="font-size: 11px;">(Leave blank if never donated before)</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3" id="bloodGroupArea">
                        <label class="form-label">Blood Group</label>
                        <select name="blood_group" class="form-select @error('blood_group') is-invalid @enderror">
                            <option value="" selected disabled>Select Group</option>
                            @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $group)
                                <option value="{{ $group }}" {{ old('blood_group') == $group ? 'selected' : '' }}>{{ $group }}
                                </option>
                            @endforeach
                        </select>
                        @error('blood_group') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 mb-3" id="phoneArea">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                            placeholder="017XXXXXXXX" value="{{ old('phone') }}" required>
                        @error('phone') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Address / Location</label>
                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                            placeholder="e.g. Cumilla, Dhaka" value="{{ old('address') }}" required>
                        @error('address') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="••••••••"
                            required>
                        @error('password') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••"
                            required>
                    </div>
                </div>

                <button type="submit" class="btn-register shadow-sm">Create My Account</button>
            </form>
        </div>
    </div>

    <script>
        function toggleFields() {
            const userRole = document.getElementById('userRole').value;
            const bloodGroupArea = document.getElementById('bloodGroupArea');
            const donorFields = document.getElementById('donorSpecificFields');
            const nameLabel = document.getElementById('nameLabel');
            const phoneArea = document.getElementById('phoneArea');

            if (userRole === 'hospital') {
                bloodGroupArea.style.display = 'none';
                donorFields.style.display = 'none';
                nameLabel.innerText = 'Hospital Name';
                phoneArea.className = 'col-md-12 mb-3';
            } else {
                bloodGroupArea.style.display = 'block';
                donorFields.style.display = 'flex';
                nameLabel.innerText = 'Full Name';
                phoneArea.className = 'col-md-6 mb-3';
            }
        }
        window.onload = toggleFields;
    </script>
</body>

</html>