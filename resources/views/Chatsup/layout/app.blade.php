<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TicketDesk - @yield('title')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  @stack('styles')
  @yield('styles')
</head>
<body>
  <div class="d-flex">
    @include('Chatsup.partials.sidebar')
    <div class="flex-grow-1">
      @yield('content')
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @yield('scripts')
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('profileBtn');
    var modalEl = document.getElementById('profileModal');
    if (btn && modalEl) {
      btn.addEventListener('click', function() {
        var modal = new bootstrap.Modal(modalEl);
        modal.show();
      });
    }
  });
</script>
</body>
</html>
