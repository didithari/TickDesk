<form method="POST" action="{{ route('updatePassword') }}" id="form-form">
    @csrf
    <div class="mb-3 text-start">
        <label for="email" class="form-label fw-semibold">Email</label>
        <input type="email" name="email" class="form-control" required id="email" placeholder="Enter your email">
      </div>
      <div class="mb-3 text-start">
        <label for="password" class="form-label fw-semibold">Password</label>
        <input type="password" name="password" class="form-control" required id="password" placeholder="Enter your password">
      </div>
      <div class="mb-3 text-end">
        <a href="/forgot-password" class="form-text">Forgot Password?</a>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-login">Login</button>
      </div>
</form>