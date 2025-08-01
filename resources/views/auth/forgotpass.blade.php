<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password - TickDesk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9fbfd;
      font-family: 'Segoe UI', sans-serif;
    }

    .forgot-card {
      max-width: 400px;
      width: 100%;
      padding: 40px 30px;
      background-color: white;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    }

    .forgot-logo {
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

    .btn-submit {
      border-radius: 10px;
      background-color: #146CFF;
      color: white;
      transition: background-color 0.3s ease;
    }

    .btn-submit:hover {
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
<body class="d-flex justify-content-center align-items-center vh-100 px-3">

  <div class="forgot-card text-center">
    <img src="https://cdn-icons-png.flaticon.com/512/4201/4201011.png" alt="TickDesk Logo" class="forgot-logo" />
    <h5 class="fw-bold">Forgot Password?</h5>
    <p class="mt-2 mb-4 text-muted">
      Enter your email and we’ll send you a link to reset your password.
    </p>

    @if (session('status'))
      <div style="color: green; font-size: 14px; margin-bottom: 16px;">
        {{session('status')}}
      </div>
    @endif

    <form method="POST" action="{{route('sendEmail')}}">
      @csrf
      <div class="mb-3 text-start">
        <label for="email" class="form-label fw-semibold">Email Address</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Enter your email" required>
        @error('email')
          <span style="color: red; font-size: 13px;">{{ $message }}</span>
        @enderror
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-submit">Send Reset Link</button>
      </div>
    </form>

    <p class="mt-4 text-muted">
      Remembered your password? <a href="/login">Back to Login</a>
    </p>
  </div>

</body>
</html>
