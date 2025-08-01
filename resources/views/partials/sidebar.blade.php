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
    <!-- Profile Image with fixed size -->
    <img src="{{ $user->profile_picture }}" class="rounded-circle profile-img" alt="Profile Picture" />

    <div>
      <div class="fw-semibold">{{ $user->name }}</div>
      <div class="text-muted text-small">{{ $user->role ?? 'Web Developer' }}</div>
    </div>
  </div>
</div>
