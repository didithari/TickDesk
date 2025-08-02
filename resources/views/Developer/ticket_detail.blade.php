@extends('layout.app')

@section('styles')
<style>
  .detail-container {
    max-width: 900px;
    margin: 40px auto;
  }
  .ticket-detail-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    padding: 24px 28px;
    margin-bottom: 24px;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }
  .ticket-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
  }
  .ticket-title {
    font-size: 1.35rem;
    font-weight: 700;
    margin-bottom: 0;
  }
  .ticket-status {
    background: #2563eb;
    color: #fff;
    font-size: 13px;
    border-radius: 12px;
    padding: 3px 16px;
    font-weight: 500;
    margin-left: 8px;
    display: inline-block;
  }
  .btn-back {
    background: #f4f6fa;
    color: #222;
    border: none;
    font-weight: 500;
    border-radius: 6px;
    padding: 7px 18px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    transition: background 0.2s;
  }
  .btn-back:hover {
    background: #e2e8f0;
  }
  .btn-take {
    background: #2563eb;
    color: #fff;
    border-radius: 6px;
    font-weight: 500;
    padding: 9px 28px;
    border: none;
    font-size: 1rem;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    transition: background 0.2s;
  }
  .btn-take:hover {
    background: #1746a2;
  }
  .ticket-info-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 16px;
    margin-top: 2px;
  }
  .ticket-id {
    color: #6b7280;
    font-size: 15px;
    font-weight: 500;
  }
  .ticket-meta {
    display: flex;
    gap: 32px;
    margin-top: 10px;
  }
  .ticket-meta-block {
    display: flex;
    flex-direction: column;
    gap: 2px;
    font-size: 15px;
  }
  .ticket-meta-label {
    color: #6b7280;
    font-size: 14px;
    font-weight: 500;
  }
  .ticket-meta-value {
    font-weight: 600;
    color: #222;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 8px;
    border: 1px solid #e5e7eb;
  }
  .problem-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    padding: 22px 28px;
    margin-bottom: 24px;
  }
  .problem-title {
    font-size: 1.07rem;
    font-weight: 700;
    margin-bottom: 10px;
    color: #222;
  }
  .problem-desc {
    color: #444;
    font-size: 16px;
    margin-bottom: 0;
    line-height: 1.7;
  }
  @media (max-width: 600px) {
    .detail-container {
      padding: 0 8px;
    }
    .ticket-detail-card, .problem-card {
      padding: 16px 8px;
    }
    .ticket-meta {
      flex-direction: column;
      gap: 8px;
    }
  }
</style>
@endsection

@section('content')
<div class="detail-container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-white px-0 mb-0" style="font-size:15px;">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Task Tickets</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ticket Details</li>
      </ol>
    </nav>
    <button onclick="window.history.back()" class="btn btn-back">
      &larr; Back to Task
    </button>
  </div>
  <div class="ticket-detail-card">
    <div class="ticket-header">
      <div>
        <span class="ticket-title">{{ $ticket->title }}</span>
        <span class="ticket-status">Open</span>
      </div>
      <button class="btn btn-take">Take Ticket</button>
    </div>
    <div class="ticket-info-row">
      <span class="ticket-id">Ticket ID: #TK-{{ date('Y', strtotime($ticket->created_at)) }}-{{ str_pad($ticket->id, 3, '0', STR_PAD_LEFT) }}</span>
    </div>
    <div class="ticket-meta mt-2">
      <div class="ticket-meta-block">
        <span class="ticket-meta-label">Submitted by</span>
        <span class="ticket-meta-value">
          <img src="{{ asset($ticket->user_avatar) }}" class="user-avatar" alt="avatar">
          {{ $ticket->support_name }}
        </span>
      </div>
      <div class="ticket-meta-block">
        <span class="ticket-meta-label">Time Submitted</span>
        <span class="ticket-meta-value">
          {{ \Carbon\Carbon::parse($ticket->created_at)->format('M d, Y \a\t h:i A') }}
        </span>
      </div>
    </div>
  </div>
  <div class="problem-card">
    <div class="problem-title">Problem Description</div>
    <p class="problem-desc">{{ $ticket-> first_response}}</p>
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.querySelector('.btn-take')?.addEventListener('click', function() {
    alert('Ticket has been taken!');
    // Tambahkan AJAX jika ingin update status
  });
</script>
@endsection