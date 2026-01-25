
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blood Bank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(180deg, #fff7f8 0%, #ffecec 60%);
        }

        .hero {
            padding: 4rem 0;
        }

        .card-cta {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        .feature {
            min-height: 120px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand" href="/">🩸 Blood Bank</a>
            <div>
                @if(auth()->check())
                    <a href="/{{ auth()->user()->role }}/dashboard"
                        class="btn btn-sm btn-outline-primary me-2">Dashboard</a>
                    <form method="POST" action="/logout" class="d-inline">@csrf<button
                            class="btn btn-sm btn-outline-secondary">Logout</button></form>
                @else
                    <a href="/login" class="btn btn-sm btn-primary me-2">Login</a>
                    <a href="/register" class="btn btn-sm btn-outline-primary">Register</a>
                @endif
            </div>
        </div>
    </nav>

    <main class="hero">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Donate. Request. Save Lives.</h1>
            <p class="lead text-muted mb-4">Simple blood bank management — register as donor, hospital or manager and
                start.</p>

            <div class="row justify-content-center mb-4">
                <div class="col-md-8">
                    <div class="card card-cta p-4">
                        <div class="d-flex gap-3 align-items-center justify-content-center">
                            <a href="/register" class="btn btn-lg btn-primary">Get Started — Register</a>
                            <a href="/login" class="btn btn-lg btn-outline-primary">Login</a>
                            <a href="/manager/reports" class="btn btn-lg btn-light">Reports</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="bg-white p-3 rounded feature text-center">
                        <h5>Donors</h5>
                        <p class="text-muted small">Book appointments and contribute blood to save lives.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white p-3 rounded feature text-center">
                        <h5>Hospitals</h5>
                        <p class="text-muted small">Request blood units for patients quickly.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white p-3 rounded feature text-center">
                        <h5>Managers</h5>
                        <p class="text-muted small">Manage inventory, approve requests and view reports.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="py-4 text-center text-muted">
        <div class="container">&copy; {{ date('Y') }} Blood Bank — built for testing and demos.</div>
    </footer>

</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Blood Bank - Landing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <div class="text-center mb-4">
            <h1 class="display-5">🩸 Blood Bank</h1>
            <p class="lead">Welcome — choose your action below</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="d-grid gap-2">
                    @if(auth()->check())
                        <a href="/{{ auth()->user()->role }}/dashboard" class="btn btn-primary btn-lg">Go to Dashboard</a>
                        <form method="POST" action="/logout">@csrf<button class="btn btn-outline-secondary">Logout</button>
                        </form>
                    @else
                        <a href="/login" class="btn btn-primary btn-lg">Login</a>
                        <a href="/register" class="btn btn-outline-primary">Register</a>
                    @endif
                    <a href="/manager/reports" class="btn btn-light">Reports (manager)</a>
                </div>
            </div>
        </div>

        <footer class="text-center mt-5 text-muted">&copy; {{ date('Y') }} Blood Bank</footer>
    </div>
</body>

</html>