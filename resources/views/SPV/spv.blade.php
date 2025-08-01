<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TickDesk - Task Developer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
      font-family: "Segoe UI", sans-serif;
    }
    .navbar-brand { font-weight: 600; font-size: 20px; }
    .navbar-subtitle { font-size: 14px; color: #6c757d; }
    .navbar-icon { font-size: 20px; color: #6c757d; margin-right: 20px; }
    .profile-img { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; }

    .stat-card {
      border-radius: 12px;
      padding: 20px;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .stat-title { margin: 0; font-size: 14px; opacity: 0.8; }
    .stat-number { font-size: 24px; margin: 0; font-weight: bold; }

    .badge-soft {
      padding: 4px 10px;
      font-size: 12px;
      border-radius: 12px;
      font-weight: 500;
    }
    .badge-light-green { background-color: #d1f4e0; color: #198754; }
    .badge-light-red { background-color: #fddede; color: #dc3545; }
    .badge-light-blue { background-color: #d7e8ff; color: #0d6efd; }
    .badge-light-yellow { background-color: #fff3cd; color: #664d03; }
    .badge-light-purple { background-color: #e6d6fa; color: #6f42c1; }

    .priority-card {
      background-color: #f9fafb;
      border: none;
      border-radius: 10px;
      padding: 16px 24px;
      position: relative;
      margin-bottom: 15px;
    }
    .priority-card::before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      width: 6px;
      height: 100%;
      border-top-left-radius: 10px;
      border-bottom-left-radius: 10px;
      background-color: #dc3545;
    }
    .priority-card.border-warning::before { background-color: #ffc107; }
    .priority-card.border-success::before { background-color: #198754; }

    .drag-icon {
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: grab;
    }

    .ticket-card.dragging {
      opacity: 0.6;
      transform: scale(0.98);
      transition: all 0.2s ease;
    }

    .ticket-card.in-progress {
      position: relative;
      z-index: 10;
      pointer-events: none;
    }

    .ticket-card.in-progress.dragging {
      opacity: 1 !important;
      transform: none !important;
      pointer-events: none;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-light bg-white shadow-sm">
  <div class="container d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-2">
      <span class="navbar-brand mb-0">TickDesk</span>
      <span class="navbar-subtitle">Support Ticket Management</span>
    </div>
    <div class="d-flex align-items-center">
      <i class="bi bi-bell navbar-icon"></i>
      <img src="https://i.pravatar.cc/300?img=12" alt="Profile" class="profile-img" id="profileImg" style="cursor:pointer;" />
    </div>
  </div>
</nav>

<div class="container mt-5 mb-5">
  <div class="row text-white mb-4 g-3">
    <div class="col-md-3">
      <div class="stat-card bg-primary shadow-sm">
        <i class="bi bi-ticket-perforated fs-4"></i>
        <div>
          <p class="stat-title">Total Tickets</p>
          <p class="stat-number">{{ $stats['total'] }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stat-card bg-danger shadow-sm">
        <i class="bi bi-exclamation-circle fs-4"></i>
        <div>
          <p class="stat-title">Open</p>
          <p class="stat-number">{{ $stats['open'] }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stat-card bg-warning text-dark shadow-sm">
        <i class="bi bi-clock fs-4"></i>
        <div>
          <p class="stat-title">In Progress</p>
          <p class="stat-number">{{ $stats['in_progress'] }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stat-card bg-success shadow-sm">
        <i class="bi bi-check-circle fs-4"></i>
        <div>
          <p class="stat-title">Resolved</p>
          <p class="stat-number">{{ $stats['resolved'] }}</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row align-items-center mb-4">
    <div class="col-md-3">
      <select class="form-select" id="roleFilter">
        <option value="All Roles">All Roles</option>
        <option value="Mobile Dev">Mobile Dev</option>
        <option value="Web Dev">Web Dev</option>
        <option value="Desktop Dev">Desktop Dev</option>
      </select>
    </div>
    <div class="col-md-3">
      <select class="form-select" id="statusFilter">
        <option value="All Status">All Status</option>
        <option value="Open">Open</option>
        <option value="In Progress">In Progress</option>
        <option value="Resolved">Resolved</option>
      </select>
    </div>
    <div class="col-md-6 text-end">
      <button class="btn btn-primary" id="saveBtn"><i class="bi bi-save me-1"></i> Save Queue Order</button>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Ticket Priority Queue</h5>
        <small class="text-muted">Drag Open tickets to reorder priority</small>
      </div>

      <div id="ticketContainer">
        @foreach ($tickets as $ticket)
          @php
            $roleColor = match($ticket['role']) {
              'Mobile Dev' => 'green',
              'Web Dev' => 'blue',
              'Desktop Dev' => 'purple',
              default => 'secondary',
            };
            $statusColor = match($ticket['status']) {
              'Open' => 'red',
              'In Progress' => 'yellow',
              'Resolved' => 'green',
              default => 'light',
            };
            $borderClass = match($ticket['status']) {
              'Open' => 'border-danger',
              'In Progress' => 'border-warning',
              'Resolved' => 'border-success',
              default => '',
            };
          @endphp

          <div class="priority-card {{ $borderClass }} ticket-card {{ $ticket['status'] === 'In Progress' ? 'in-progress' : '' }}"
               data-role="{{ $ticket['role'] }}"
               data-status="{{ $ticket['status'] }}"
               @if ($ticket['status'] === 'Open') draggable="true" @endif>
            <div class="drag-icon text-muted"><i class="bi bi-grip-vertical fs-5"></i></div>
            <div>
              <div class="mb-1">
                <strong>#{{ $ticket['code'] }}</strong>
                <span class="badge badge-soft badge-light-{{ $roleColor }}">{{ $ticket['role'] }}</span>
                <span class="badge badge-soft badge-light-{{ $statusColor }}">{{ $ticket['status'] }}</span>
              </div>
              <div class="fw-semibold">{{ $ticket['title'] }}</div>
              <div class="text-muted small">User: {{ $ticket['user'] }} • Submitted: {{ \Carbon\Carbon::parse($ticket['submitted_at'])->diffForHumans() }}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

<!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Logout Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to logout?
      </div>
      <div class="modal-footer">
        <form id="logoutForm" method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Logout</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS Bundle (Popper included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const container = document.getElementById("ticketContainer");
  const roleFilter = document.getElementById("roleFilter");
  const statusFilter = document.getElementById("statusFilter");

  roleFilter.addEventListener("change", filterTickets);
  statusFilter.addEventListener("change", filterTickets);

  function filterTickets() {
    const role = roleFilter.value.toLowerCase();
    const status = statusFilter.value.toLowerCase();

    const tickets = container.querySelectorAll(".ticket-card");
    tickets.forEach(ticket => {
      const ticketRole = ticket.dataset.role.toLowerCase();
      const ticketStatus = ticket.dataset.status.toLowerCase();
      const show = (role === "all roles" || role === ticketRole) &&
                   (status === "all status" || status === ticketStatus);
      ticket.style.display = show ? "block" : "none";
    });
  }

  let draggedItem = null;

  container.addEventListener("dragstart", function (e) {
    const card = e.target.closest(".ticket-card");
    if (card && card.dataset.status === "Open") {
      draggedItem = card;
      const ghost = document.createElement("div");
      ghost.style.position = "absolute";
      ghost.style.top = "-9999px";
      document.body.appendChild(ghost);
      e.dataTransfer.setDragImage(ghost, 0, 0);
      card.classList.add("dragging");
    } else {
      e.preventDefault();
    }
  });

  container.addEventListener("dragend", function () {
    if (draggedItem) {
      draggedItem.classList.remove("dragging");
      draggedItem = null;
    }
  });

  container.addEventListener("dragover", function (e) {
    e.preventDefault();
    const target = e.target.closest(".ticket-card");
    if (!draggedItem || !target || target === draggedItem) return;

    if (draggedItem.dataset.status !== "Open" || target.dataset.status !== "Open") return;

    const bounding = target.getBoundingClientRect();
    const offset = bounding.y + bounding.height / 2;

    if (e.clientY > offset) {
      target.after(draggedItem);
    } else {
      target.before(draggedItem);
    }
  });

  // Profile click for logout
  document.getElementById("profileImg").addEventListener("click", function () {
    var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
    logoutModal.show();
  });
});
</script>

</body>
</html>
