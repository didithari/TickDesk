@extends('layout.sidebarsup')

@section('title', 'Developer Ticket Chat')

@section('content')
<div class="container-fluid">
  <div class="row vh-100">

    <!-- Sidebar -->
    <div class="col-md-2 border-end bg-white d-flex flex-column p-3">
      <h5 class="fw-bold mb-4">TickDesk</h5>
      <ul class="nav flex-column mb-auto">
        <li class="nav-item mb-2">
          <a href="#" class="nav-link active text-primary">
            <i class="bi bi-chat-left-text me-2"></i> Chat
          </a>
        </li>
        <li class="nav-item mb-2">
          <a href="#" class="nav-link text-dark">
            <i class="bi bi-clock-history me-2"></i> History
          </a>
        </li>
      </ul>

      <div class="my-3">
        <button class="btn btn-primary w-100">+ New Chat</button>
      </div>

      <div class="mt-auto pt-3 border-top d-flex align-items-center">
        <img src="{{ $user['avatar'] }}" class="rounded-circle me-2" width="40" height="40">
        <div>
          <div class="fw-semibold">{{ $user['name'] }}</div>
          <div class="text-muted" style="font-size: 0.85rem;">{{ $user['role'] }}</div>
        </div>
      </div>
    </div>

    <!-- Ticket List -->
    <div class="col-md-3 bg-light border-end p-3 overflow-auto">
      <div class="list-group">
        @foreach($tickets as $id => $ticket)
        <a href="{{ route('Chatsup.chatsup.show', $id) }}"
           class="list-group-item list-group-item-action mb-2 {{ $activeId == $id ? 'border-primary border-2' : '' }}">
          <div class="fw-bold">{{ $ticket['code'] }}</div>
          <div class="text-muted small">{{ $ticket['title'] }}</div>
          <div class="text-muted small">User: {{ $ticket['user'] }}<br>{{ $ticket['time'] }}</div>
          <span class="badge bg-primary float-end mt-1">{{ $ticket['status'] }}</span>
        </a>
        @endforeach
      </div>
    </div>

    <!-- Chat Detail -->
    <div class="col-md-7 d-flex flex-column p-0" style="height: 100vh;">
      <!-- Header -->
      <div class="p-4 border-bottom">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <h5 class="fw-bold mb-0">{{ $activeTicket['code'] ?? 'Ticket #' . $activeId }}</h5>
            <div class="text-muted">{{ $activeTicket['title'] }}</div>
          </div>
          <span class="badge bg-primary">{{ $activeTicket['status'] }}</span>
        </div>
      </div>

      <!-- Chat Scrollable -->
      <div id="chat-box" class="flex-grow-1 overflow-auto px-4 py-3"
           style="background: #fff; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6;">
        @foreach($messages as $msg)
        @if($msg['side'] === 'left')
        <div class="mb-4 d-flex mt-2">
          <img src="{{ $msg['avatar'] }}" class="rounded-circle me-2" width="40" height="40">
          <div>
            <div class="bg-light rounded p-2">{{ $msg['message'] }}</div>
            <div class="text-muted small mt-1">{{ $msg['time'] }}</div>
          </div>
        </div>
        @else
        <div class="mb-4 d-flex flex-row-reverse text-end mt-2">
          <img src="{{ $msg['avatar'] }}" class="rounded-circle ms-2" width="40" height="40">
          <div>
            <div class="bg-primary text-white rounded p-2">{{ $msg['message'] }}</div>
            <div class="text-muted small mt-1">{{ $msg['time'] }}</div>
          </div>
        </div>
        @endif
        @endforeach
      </div>

      <!-- Chat Input -->
      <div class="p-4 border-top bg-white">
        <form>
          <div class="d-flex align-items-center mb-3">
            <input type="text" class="form-control me-2" placeholder="Type your message...">
            <button class="btn btn-primary"><i class="bi bi-send-fill"></i></button>
          </div>
          <div class="text-end">
            <button type="button" class="btn btn-outline-primary">✓ Close Ticket</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Auto Scroll -->
<script>
  const chatBox = document.getElementById('chat-box');
  if (chatBox) {
    chatBox.scrollTop = chatBox.scrollHeight;
  }
</script>
@endsection
