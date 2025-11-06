<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Pawfect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #f9f4ef, #fff);
            font-family: 'Poppins', sans-serif;
            color: #5a4634;
        }

        .login-card {
            background-color: #fffaf3;
            border: none;
            border-radius: 20px;
            box-shadow: 0px 8px 20px rgba(149, 105, 63, 0.15);
            padding: 2rem;
        }

        .brand-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-direction: column;
        }

        .brand-logo img {
            width: 90px;
            height: 90px;
            object-fit: contain;
        }

        .brand-logo h4 {
            margin-top: 10px;
            font-weight: 700;
            color: #8b5e3c;
        }

        .form-label {
            color: #8b5e3c;
            font-weight: 500;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #decbb5;
            background-color: #fff;
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus {
            border-color: #d2a679;
            box-shadow: 0 0 6px rgba(210, 166, 121, 0.3);
        }

        .btn-login {
            background-color: #d4a574;
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #c28e5e;
            transform: translateY(-2px);
            box-shadow: 0px 6px 10px rgba(140, 90, 50, 0.2);
        }

        .card-footer-text {
            color: #7b6a55;
        }

        .card-footer-text a {
            color: #c28e5e;
            text-decoration: none;
            font-weight: 600;
        }

        .card-footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="col-md-5">
        <div class="login-card shadow">
            <div class="brand-logo">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Pawfect Logo">
                <h4>Pawfect Pet Supply</h4>
            </div>

            <h5 class="text-center mb-4 fw-semibold">Login ke Akun Anda</h5>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button class="btn btn-login w-100 py-2">Login</button>
            </form>

            <p class="text-center mt-3 card-footer-text">
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
