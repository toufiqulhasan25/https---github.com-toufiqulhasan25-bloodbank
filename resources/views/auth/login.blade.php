<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | NIYD Blood Bank</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root { --primary-color: #BE1E2D; --dark-blue: #002B49; --light-bg: #F4F7F9; }
        
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: var(--light-bg); 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }

        .login-card { 
            background: #fff; 
            border-radius: 30px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.1); 
            overflow: hidden; 
            max-width: 950px; 
            width: 95%; 
            display: flex; 
        }

        .login-side-img { 
            background: var(--dark-blue); 
            color: white; 
            padding: 60px; 
            width: 40%; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            position: relative;
        }

        .login-form-area { 
            padding: 60px; 
            width: 60%; 
            position: relative; /* বাটন পজিশনিং এর জন্য */
        }

        /* কার্ডের ভেতরে ব্যাক বাটন */
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
        }

        .btn-home-corner:hover {
            background: var(--primary-color);
            color: #fff;
            box-shadow: 0 4px 12px rgba(190, 30, 45, 0.2);
        }

        .form-label { font-weight: 600; color: var(--dark-blue); margin-bottom: 8px; }

        .form-control { 
            border-radius: 10px; 
            padding: 12px 15px; 
            border: 1px solid #ddd; 
            margin-bottom: 20px; 
        }

        .form-control:focus { 
            border-color: var(--primary-color); 
            box-shadow: 0 0 0 0.25rem rgba(190, 30, 45, 0.1); 
        }

        .input-group-text {
            background: none;
            border-radius: 0 10px 10px 0;
            border-left: none;
            margin-bottom: 20px;
            cursor: pointer;
            color: #666;
        }

        .password-input {
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .btn-login { 
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
            margin-top: 10px;
        }

        .btn-login:hover { 
            background: #961824; 
            transform: translateY(-2px); 
        }

        @media (max-width: 768px) { 
            .login-card { flex-direction: column; } 
            .login-side-img { width: 100%; padding: 40px 20px; text-align: center; } 
            .login-form-area { width: 100%; padding: 40px 30px; } 
            .btn-home-corner { top: 15px; right: 15px; }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-side-img d-none d-md-flex">
            <a href="/"><img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px; filter: brightness(0) invert(1); margin-bottom: 40px;"></a>
            <h2 class="fw-bold mb-4">Welcome Back, Hero.</h2>
            <p class="opacity-75">Log in to your account to continue saving lives and managing requests.</p>
            
        </div>

        <div class="login-form-area">
            <a href="/" class="btn-home-corner">
                <i class="fa-solid fa-house me-1"></i> Home
            </a>

            <h3 class="fw-bold mb-1 mt-2">Account Login</h3>
            <p class="text-muted mb-4">New here? <a href="/register" class="text-danger fw-bold text-decoration-none">Create account</a></p>

            <form action="/login" method="POST">
                @csrf
                <div class="mb-1">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                </div>

                <div class="mb-1">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control password-input" placeholder="••••••••" required>
                        <span class="input-group-text" onclick="togglePass()">
                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label small text-muted" for="remember">Remember me</label>
                    </div>
                    <a href="#" class="text-muted small text-decoration-none">Forgot Password?</a>
                </div>

                <button type="submit" class="btn-login">Sign In</button>
            </form>
        </div>
    </div>

    <script>
        function togglePass() {
            const passInput = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (passInput.type === 'password') {
                passInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>