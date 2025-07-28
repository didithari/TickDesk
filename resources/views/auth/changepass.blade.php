<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password - TickDesk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9fbfd;
      font-family: 'Segoe UI', sans-serif;
    }

    .reset-card {
      max-width: 400px;
      width: 100%;
      padding: 40px 30px;
      background-color: white;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    }

    .reset-logo {
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

    .btn-reset {
      border-radius: 10px;
      background-color: #146CFF;
      color: white;
      transition: background-color 0.3s ease;
    }

    .btn-reset:hover {
      background-color: #125ee3;
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

  <div class="reset-card text-center">
    <img src="https://cdn-icons-png.flaticon.com/512/4201/4201011.png" alt="TickDesk Logo" class="reset-logo" />
    <h5 class="fw-bold">Reset Your Password</h5>
    <p class="mt-2 mb-4 text-muted">
      Please enter your new password below.
    </p>
    <form method="POST" action="{{ route('updatePassword') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">
      <input type="hidden" name="email" value="{{ request('email') }}">
      <div class="mb-3 text-start">
        <label for="new-password" class="form-label fw-semibold">New Password</label>
        <input type="password" class="form-control" name="password" id="new-password" placeholder="Enter new password" required>
      </div>

      <div class="mb-3 text-start">
        <label for="retype-password" class="form-label fw-semibold">Retype Password</label>
        <input type="password" class="form-control" name="password_confirmation" id="retype-password" placeholder="Retype your password" required>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-reset">Update Password</button>
      </div>
    </form>
  </div>

</body>
</html>
