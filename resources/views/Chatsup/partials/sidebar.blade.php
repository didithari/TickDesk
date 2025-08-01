<style>
  .sidebar {
    width: 250px;
    height: 100vh;
    background-color: #fff;
    border-right: 1px solid #dee2e6;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .nav-link {
    color: #212529 !important;
    padding: 10px 16px;
    border-radius: 8px;
  }

  .nav-link.active {
    background-color: #eaf1ff;
    color: #0d6efd !important;
    font-weight: 500;
  }

  .user-footer {
    padding: 8px 16px;
    border-top: 1px solid #dee2e6;
    background-color: #fff;
    margin: 9px;
    border-radius: 12px;
    min-width: 200px;
  }

  .profile-img {
    width: 40px; /* Fixed width */
    height: 40px; /* Fixed height */
    object-fit: cover; /* Maintain image aspect ratio while filling the container */
  }
</style>

<div class="sidebar d-flex flex-column px-3">
  <div>
    <div class="d-flex align-items-center mb-4 mt-3">
      <img src="{{ asset('assetsadmin/img/div.png') }}" alt="Logo" width="40" height="40" class="me-2" />
      <span class="fw-bold fs-5">TickDesk</span>
    </div>
    <nav class="nav flex-column">
      <a class="nav-link {{ request()->is('dev/taskticket*') ? 'active' : '' }}" href="{{ route('Developer.developer') }}">
        <i class="bi bi-journal-text me-2"></i> Task Ticket
      </a>
      <a class="nav-link {{ request()->is('dev/chatdev*') ? 'active' : '' }}" href="{{ route('Chatdev.chatdev') }}">
        <i class="bi bi-chat-dots me-2"></i> Chat
      </a>
    </nav>
  </div>
  <div class="user-footer d-flex align-items-center gap-2">
    <button id="profileBtn" class="btn btn-light w-100 d-flex align-items-center justify-content-start gap-2 fw-semibold">
      <img src="{{ $user->profile_picture }}" class="rounded-circle profile-img" alt="Profile Picture" />
      <span>
        {{ $user->name }}<br>
        <span class="text-muted text-small">{{ $user->role ?? 'Web Developer' }}</span>
      </span>
    </button>
  </div>
</div>

<!-- Modal Popup Profile -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profileModalLabel">Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="{{ $user->profile_picture }}" class="rounded-circle mb-2" width="60" height="60" alt="Profile Picture" />
        <div class="fw-semibold fs-5">{{ $user->name }}</div>
        <div class="text-muted mb-3">{{ $user->role ?? 'Web Developer' }}</div>
        <!-- Tambahkan menu lain di sini jika perlu -->
        <form id="logoutForm" action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-outline-danger w-100 mt-2">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

@section('scripts')
<script>
  document.getElementById('profileBtn').addEventListener('click', function() {
    var modal = new bootstrap.Modal(document.getElementById('profileModal'));
    modal.show();
  });
</script>
@endsection