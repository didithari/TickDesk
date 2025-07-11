@extends('layout.app')

@section('title', 'Chat Ticket')

@section('styles')
<style>
  .chat-body {
    padding: 20px;
    overflow-y: auto;
    flex-grow: 1;
    height: calc(100vh - 230px);
    background-color: #ffffff;
    border-top: 1px solid #dee2e6;
    border-bottom: 1px solid #dee2e6;
  }

  .chat-history {
    width: 300px;
    border-right: 1px solid #dee2e6;
    height: 100vh;
    overflow-y: auto;
    background-color: #fff;
  }

  .chat-panel {
    flex-grow: 1;
    height: 100vh;
    display: flex;
    flex-direction: column;
  }

  .chat-divider {
    border-bottom: 1px solid #f1f3f5;
    padding-bottom: 16px;
    margin-bottom: 16px;
  }

  .message {
    max-width: 75%;
    padding: 12px 16px;
    border-radius: 12px;
  }

  .message.user {
    background-color: #f1f3f5;
    color: #212529;
  }

  .message.dev {
    background-color: #0d6efd;
    color: #fff;
    margin-left: auto;
  }

  .chat-input-section {
    background-color: #fff;
    padding: 16px 20px 10px 20px;
    border-top: 1px solid #dee2e6;
  }

  .mark-resolved-btn {
    background-color: #20c997;
    border: none;
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 14px;
    box-shadow: 0 2px 4px rgba(32, 201, 151, 0.3);
    transition: all 0.3s ease;
  }

  .mark-resolved-btn:hover {
    background-color: #17b28c;
    box-shadow: 0 4px 6px rgba(23, 178, 140, 0.4);
  }

  .chat-image-clickable {
    max-width: 250px;
    cursor: zoom-in;
  }
</style>
@endsection

@section('content')
<div class="d-flex">
  <div class="chat-history p-3">
    <h6 class="fw-bold mb-3">Chat History</h6>
    @foreach ($tickets as $ticket)
      @php
        $isActive = $ticket['id'] === $selectedTicket['id'];
        $statusClass = match($ticket['status']) {
            'Open' => 'bg-warning text-dark',
            'In Progress' => 'bg-primary',
            'Resolved' => 'bg-success',
            default => 'bg-secondary'
        };
      @endphp
      <a href="{{ route('Chatdev.chatdev', ['ticket' => $ticket['id']]) }}" class="text-decoration-none text-dark">
        <div class="ticket-card mb-2 p-2 rounded {{ $isActive ? 'bg-light' : '' }}">
          <span class="badge {{ $statusClass }} badge-status mb-1">{{ $ticket['status'] }}</span>
          <div class="fw-semibold text-primary">{{ $ticket['id'] }}</div>
          <div class="mb-1">{{ $ticket['title'] }}</div>
          <small class="text-muted">{{ $ticket['user']['name'] }} • {{ $ticket['created_at'] }}</small>
        </div>
      </a>
    @endforeach
  </div>

  <div class="chat-panel d-flex flex-column">
    <div class="ticket-header p-3 border-bottom">
      <strong>Ticket {{ $selectedTicket['id'] }}: {{ $selectedTicket['title'] }}</strong>
    </div>

    <div class="chat-body" id="chatBody">
      @foreach ($selectedTicket['messages'] as $msg)
        @if ($msg['sender'] === 'user')
          <div class="chat-divider">
            <div class="d-flex">
              <img src="{{ $msg['avatar'] }}" class="rounded-circle me-2 mt-1" width="32" height="32" />
              <div>
                <div class="message user">
                  {{ $msg['message'] }}
                </div>
                @if (isset($msg['image']))
                  <div class="mt-2">
                    <img src="{{ $msg['image'] }}" class="img-thumbnail rounded shadow-sm chat-image-clickable" alt="attached image">
                  </div>
                @endif
                <div class="text-small text-muted mt-1">{{ $msg['time'] }}</div>
              </div>
            </div>
          </div>
        @else
          <div class="chat-divider text-end">
            <div class="d-flex justify-content-end align-items-start">
              <div>
                <div class="message dev">
                  {{ $msg['message'] }}
                </div>
                @if (isset($msg['image']))
                  <div class="mt-2 text-end">
                    <img src="{{ $msg['image'] }}" class="img-thumbnail rounded shadow-sm chat-image-clickable" alt="attached image">
                  </div>
                @endif
                <div class="text-small text-muted mt-1 text-end">{{ $msg['time'] }}</div>
              </div>
              <img src="{{ $msg['avatar'] }}" class="rounded-circle ms-2 mt-1" width="32" height="32" />
            </div>
          </div>
        @endif
      @endforeach
    </div>

    <div class="chat-input-section">
      <div class="d-flex align-items-end gap-2 mb-2">
        <textarea class="form-control" rows="2" placeholder="Type your message..." style="resize: none;"></textarea>
        <button class="btn btn-primary rounded px-3 py-2"><i class="bi bi-send-fill"></i></button>
        <button class="btn d-flex align-items-center gap-2 text-white mark-resolved-btn">
          <i class="bi bi-check-circle-fill fs-5"></i>
          <span class="fw-semibold">Mark as Resolved</span>
        </button>
      </div>
      <div class="d-flex gap-2 pt-1">
        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-paperclip"></i> File</button>
        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-image"></i> Image</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <img id="modalImage" src="" class="img-fluid rounded shadow" />
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/chatdev.js') }}"></script>
@endsection

