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
        :root { --primary-color: #BE1E2D; --dark-blue: #002B49; --light-bg: #F4F7F9; }
        body { font-family: 'Outfit', sans-serif; background-color: var(--light-bg); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 0; }
        .reg-card { background: #fff; border-radius: 30px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); overflow: hidden; max-width: 1000px; width: 95%; display: flex; position: relative; }
        .reg-side-info { background: var(--dark-blue); color: white; padding: 60px; width: 40%; display: flex; flex-direction: column; justify-content: center; }
        .reg-form-area { padding: 60px; width: 60%; position: relative; }

        /* লগইন পেজের মতো কর্নার বাটন স্টাইল */
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

        .form-label { font-weight: 600; color: var(--dark-blue); margin-bottom: 8px; }
        .form-control, .form-select { border-radius: 10px; padding: 12px 15px; border: 1px solid #ddd; margin-bottom: 20px; }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 0.25rem rgba(190, 30, 45, 0.1); }
        .btn-register { background: var(--primary-color); color: white; width: 100%; padding: 15px; border-radius: 50px; font-weight: 700; border: none; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; }
        .btn-register:hover { background: #961824; transform: translateY(-2px); }
        
        @media (max-width: 768px) { 
            .reg-card { flex-direction: column; } 
            .reg-side-info, .reg-form-area { width: 100%; padding: 30px; } 
            .btn-home-corner { top: 15px; right: 15px; }
        }
    </style>
</head>
<body>
    <div class="reg-card">
        <div class="reg-side-info d-none d-md-flex">
            <a href="/"><img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px; filter: brightness(0) invert(1); margin-bottom: 40px;"></a>
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
            <p class="text-muted mb-4">Already have an account? <a href="/login" class="text-danger fw-bold text-decoration-none">Login</a></p>

            <form action="/register" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label" id="nameLabel">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Who Are You?</label>
                        <select name="user_type" id="userType" class="form-select" required onchange="toggleFields()">
                            <option value="" selected disabled>Select Role</option>
                            <option value="donor">Individual Donor</option>
                            <option value="hospital">Hospital / Medical Center</option>
                            <option value="manager">System Manager</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" id="bloodGroupArea">
                        <label class="form-label">Blood Group</label>
                        <select name="blood_group" class="form-select">
                            <option value="" selected disabled>Select Group</option>
                            <option value="A+">A+</option><option value="A-">A-</option>
                            <option value="B+">B+</option><option value="B-">B-</option>
                            <option value="O+">O+</option><option value="O-">O-</option>
                            <option value="AB+">AB+</option><option value="AB-">AB-</option>
                        </select>
                    </div>
                    <div class="col-md-6" id="phoneArea">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="017XXXXXXXX" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn-register shadow-sm">Create My Account</button>
            </form>
        </div>
    </div>

    <script>
        function toggleFields() {
            const userType = document.getElementById('userType').value;
            const bloodGroupArea = document.getElementById('bloodGroupArea');
            const nameLabel = document.getElementById('nameLabel');
            const phoneArea = document.getElementById('phoneArea');
            if (userType === 'hospital') {
                bloodGroupArea.style.display = 'none';
                nameLabel.innerText = 'Hospital Name';
                phoneArea.className = 'col-md-12';
            } else {
                bloodGroupArea.style.display = 'block';
                nameLabel.innerText = 'Full Name';
                phoneArea.className = 'col-md-6';
            }
        }
    </script>
</body>
</html>