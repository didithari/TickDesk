<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>TickDesk Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9fbfd;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-card {
      max-width: 400px;
      width: 100%;
      padding: 40px 30px;
      background-color: white;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    }

    .login-logo {
      display: block;
      margin: 0 auto 15px auto;
      width: 50px;
      height: 50px;
    }

    .form-control {
      border-radius: 10px;
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .btn-login {
      border-radius: 10px;
      background-color: #146CFF;
      color: white;
      transition: background-color 0.3s ease;
    }

    .btn-login:hover {
      background-color: #125ee3;
    }

    .form-text a {
      font-weight: 500;
      color: #146CFF;
      text-decoration: none;
    }

    .form-text a:hover {
      text-decoration: underline;
    }

    footer {
      text-align: center;
      font-size: 0.8rem;
      color: #adb5bd;
      margin-top: 40px;
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

  <div class="login-card text-center">
    <!-- Ganti URL logo di bawah jika perlu -->
    <img src="https://cdn-icons-png.flaticon.com/512/4201/4201011.png" alt="TickDesk Logo" class="login-logo" />
    <h5 class="fw-bold">TickDesk</h5>
    <p class="mt-2 mb-4 text-muted">Login to your account<br><small>Welcome back! Please enter your details.</small></p>

    <form>
      <div class="mb-3 text-start">
        <label for="email" class="form-label fw-semibold">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Enter your email">
      </div>
      <div class="mb-3 text-start">
        <label for="password" class="form-label fw-semibold">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Enter your password">
      </div>
      <div class="mb-3 text-end">
        <a href="/forgot-password" class="form-text">Forgot Password?</a>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-login">Login</button>
      </div>
    </form>
  </div>

</body>
</html>
