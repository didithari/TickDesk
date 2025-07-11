@extends('layout.app')

@section('title', 'Developer Tickets')

@section('styles')
<style>
  .main-content {
    padding: 30px;
  }

  .ticket-card {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    padding: 16px;
    margin-bottom: 16px;
    border: 1px solid #e0e0e0;
  }

  .ticket-type {
    font-size: 12px;
    font-weight: 500;
    padding: 4px 8px;
    border-radius: 12px;
    color: white;
  }

  .ticket-type.web { background-color: #5B9BFF; }
  .ticket-type.mobile { background-color: #7DD3A8; }
  .ticket-type.desktop { background-color: #C084FC; }

  .status-badge {
    border: 1px solid #0d6efd;
    color: #0d6efd;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 14px;
    background-color: #fff;
  }

  .btn-take {
    background-color: #28a745;
    color: white;
  }

  .btn-take:hover {
    background-color: #218838;
  }

  .tabs .nav-link {
    color: #000;
    border: none;
    font-weight: 500;
  }

  .tabs .nav-link.active {
    color: #0d6efd;
    border-bottom: 3px solid #0d6efd;
  }

  #ticket-list {
    max-height: 70vh;
    overflow-y: auto;
    padding-right: 10px;
  }
</style>
@endsection

@section('content')
<div class="main-content">
  <h4 class="fw-bold">Support Tickets</h4>
  <p class="text-muted">Manage and respond to support requests</p>

  <ul class="nav nav-tabs tabs mb-3" id="role-tabs">
    <li class="nav-item"><a class="nav-link active" data-role="all" href="#">All Tickets</a></li>
    <li class="nav-item"><a class="nav-link" data-role="mobile" href="#">Mobile Dev</a></li>
    <li class="nav-item"><a class="nav-link" data-role="web" href="#">Web Dev</a></li>
    <li class="nav-item"><a class="nav-link" data-role="desktop" href="#">Desktop Dev</a></li>
  </ul>

  <div id="ticket-list">
    @foreach ($tickets as $ticket)
    <div class="ticket-card" data-role="{{ $ticket['type'] }}">
      <div class="d-flex justify-content-between">
        <div>
          <div class="small text-muted">
            #TK-2025-{{ $ticket['id'] }} <span class="ticket-type {{ $ticket['type'] }} ms-2">{{ ucfirst($ticket['type']) }} Dev</span>
          </div>
          <h6 class="mt-2 mb-1">{{ $ticket['title'] }}</h6>
          <div class="text-muted" style="font-size: 14px;">
            <i class="bi bi-person-fill me-1"></i> {{ $ticket['name'] }}
            <i class="bi bi-clock ms-3 me-1"></i> {{ $ticket['time'] }}
          </div>
        </div>
        <div class="text-end">
          <div class="ticket-actions mt-2">
            <span class="status-badge">Open</span>
            <button class="btn btn-sm btn-take">Take Ticket</button>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll("#role-tabs .nav-link");
    const cards = document.querySelectorAll(".ticket-card");

    tabs.forEach(tab => {
      tab.addEventListener("click", function (e) {
        e.preventDefault();

        tabs.forEach(t => t.classList.remove("active"));
        this.classList.add("active");

        const role = this.getAttribute("data-role");

        cards.forEach(card => {
          const cardRole = card.getAttribute("data-role");
          if (role === "all" || cardRole === role) {
            card.style.display = "block";
          } else {
            card.style.display = "none";
          }
        });
      });
    });

    const takeButtons = document.querySelectorAll(".btn-take");
    takeButtons.forEach(btn => {
      btn.addEventListener("click", function () {
        alert("Ticket has been taken!");
        // Di sini bisa ditambahkan AJAX ke server jika diperlukan
      });
    });
  });
</script>
@endsection
