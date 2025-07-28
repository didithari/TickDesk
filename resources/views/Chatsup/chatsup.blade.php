@extends('Chatsup.layout.app')

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
    box-shadow: 0 4px 6px rgba(23,178,140,0.4);
  }

  .chat-image-clickable {
    max-width: 250px;
    cursor: zoom-in;
    margin-top: 8px;
  }

  #selectedImageContainer {
    display: none;
    margin-bottom: 10px;
  }

  #selectedImage {
    max-width: 150px;
    height: auto;
  }

  .file-box {
    border: 1px solid #dee2e6;
    background: #f8f9fa;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 6px;
    max-width: 250px;
    margin-bottom: 4px;
    word-break: break-all;         /* <-- Tambahkan ini */
    overflow-wrap: anywhere;       /* <-- Tambahkan ini */
    margin-top: 16px !important;
  }
  .file-box a {
    word-break: break-all;         /* <-- Tambahkan ini */
    overflow-wrap: anywhere;       /* <-- Tambahkan ini */
    display: inline-block;         /* <-- Tambahkan ini */
    max-width: 180px;              /* <-- Tambahkan ini, agar link tidak melebar */
    white-space: normal;           /* <-- Tambahkan ini */
    text-overflow: ellipsis;       /* <-- Tambahkan ini */
    overflow: hidden;              /* <-- Tambahkan ini */
    vertical-align: middle;
  }

  .ticket-info-bar {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    margin: 18px 18px 0 18px;
    padding: 28px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 90px;
    border: 1px solid #f1f3f5;
  }
  .ticket-info-bar .info-group {
    display: flex;
    gap: 48px;
    align-items: center;
  }
  .ticket-info-bar .info-label {
    color: #6c757d;
    font-size: 15px;
    font-weight: 500;
    margin-bottom: 2px;
  }
  .ticket-info-bar .info-value {
    color: #212529;
    font-size: 21px;
    font-weight: 700;
    margin-bottom: 0;
  }
  .ticket-info-bar .info-title {
    font-size: 20px;
    font-weight: 600;
    color: #212529;
    margin-bottom: 0;
  }
  .ticket-info-bar .status-badge {
    background: #e9f3ff;
    color: #2563eb;
    font-weight: 600;
    font-size: 16px;
    border-radius: 18px;
    padding: 6px 22px;
    display: inline-flex;
    align-items: center;
    gap: 7px;
  }
  .ticket-info-bar .status-badge .bi {
    font-size: 17px;
    vertical-align: middle;
  }
  .ticket-info-bar .submitter {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .ticket-info-bar .submitter-img {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #f1f3f5;
  }
  .ticket-info-bar .submitter-details {
    display: flex;
    flex-direction: column;
  }
  .ticket-info-bar .submitter-name {
    font-weight: 600;
    font-size: 17px;
    color: #212529;
    margin-bottom: 0;
  }
  .ticket-info-bar .submitter-email {
    font-size: 15px;
    color: #6c757d;
    margin-bottom: 0;
  }
</style>
@endsection

@section('content')
<div class="d-flex">
  <div class="chat-history p-3">
    <h6 class="fw-bold mb-3">Chat History</h6>
    @foreach ($tickets as $ticket)
      @php
        $isActive = $ticket->id === $selectedTicket->id;

        $statusClass = match($ticket->status) {
            'Open' => 'bg-warning text-dark',
            'In Progress' => 'bg-primary',
            'Resolved' => 'bg-success',
            default => 'bg-secondary'
        };
    @endphp

      <a href="{{ route('Chatsup.chatsup', ['ticket' => $ticket->id]) }}" class="text-decoration-none text-dark">
        <div class="ticket-card mb-2 p-2 rounded {{ $isActive ? 'bg-light' : '' }}">
          <span class="badge {{ $statusClass }} badge-status mb-1">{{ $ticket->status }}</span>
          <div class="fw-semibold text-primary">{{ $ticket->id }}</div>
          <div class="mb-1">{{ $ticket->title }}</div>
          <small class="text-muted">{{ $ticket->developer_name }} • {{ $ticket->created_at }}</small>
        </div>
      </a>
    @endforeach
  </div>

  <div class="chat-panel d-flex flex-column">
    <!-- Ticket Info Top Bar -->
    <div class="ticket-info-bar">
      <div class="info-group">
        <div>
          <div class="info-label">Ticket ID</div>
          <div class="info-value">#{{ $selectedTicket->id }}</div>
        </div>
        <div>
          <div class="info-label">Title</div>
          <div class="info-title">{{ $selectedTicket->title }}</div>
        </div>
        <div>
          <div class="info-label">Status</div>
          <span class="status-badge">
            <i class="bi bi-clock"></i>
            {{ $selectedTicket->status }}
          </span>
        </div>
      </div>
      <div class="submitter">
        <img src="{{ $selectedTicket->developer_avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($selectedTicket->developer_name) }}" class="submitter-img" />
        <div class="submitter-details">
          <div class="submitter-name">{{ $selectedTicket->developer_name }}</div>
          <div class="submitter-email">{{ $selectedTicket->developer_email ?? '' }}</div>
        </div>
      </div>
    </div>
    <!-- End Ticket Info Top Bar -->

    <div class="chat-body" id="chatBody">
      @foreach ($selectedTicket->messages as $msg)
        @if ($msg['sender'] === 'dev')
        <div class="chat-divider">
            <div class="d-flex">
                <img src="{{ $msg['avatar'] }}" class="rounded-circle me-2 mt-1" width="32" height="32" />
                <div>
                    @if (isset($msg['message']))
                      <div class="message user mb-2" style="max-width: 300px;">
                          {{ $msg['message'] }}
                      </div>
                    @endif
                    @if (isset($msg['image']))
                        <div class="mt-3">
                            <img src="{{ $msg['image'] }}" class="img-thumbnail rounded shadow-sm chat-image-clickable" alt="attached image">
                        </div>
                    @endif
                    @if($msg['attachment'])
                        <div class="mt-3">
                            @if($msg['attachment']['type'] === 'image')
                                <img src="{{ $msg['attachment']['url'] }}" alt="{{ $msg['attachment']['name'] }}" class="chat-image-clickable" style="max-width:200px; margin-top:8px;">
                            @else
                                <div class="file-box mt-2 p-2 rounded bg-light border d-inline-block" style="margin-top:8px;">
                                    <i class="bi bi-file-earmark-arrow-down me-2"></i>
                                    <a href="{{ $msg['attachment']['url'] }}" download class="fw-semibold text-primary">{{ $msg['attachment']['name'] }}</a>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="text-small text-muted mt-1">{{ $msg['time'] }}</div>
                </div>
            </div>
        </div>
        @elseif ($msg['sender'] === 'support')
        <div class="chat-divider text-end">
            <div class="d-flex justify-content-end align-items-start">
                <div>
                    @if (isset($msg['message']))
                      <div class="message dev" style="max-width: 300px;">
                          {{ $msg['message'] }}
                      </div>
                    @endif
                    @if (isset($msg['image']))
                        <div class="mt-2 text-end">
                            <img src="{{ $msg['image'] }}" class="img-thumbnail rounded shadow-sm chat-image-clickable" alt="attached image">
                        </div>
                    @endif
                    @if($msg['attachment'])
                        @if($msg['attachment']['type'] === 'image')
                            <img src="{{ $msg['attachment']['url'] }}" alt="{{ $msg['attachment']['name'] }}" class="chat-image-clickable" style="max-width:200px;">
                        @else
                            <div class="file-box mt-2 p-2 rounded bg-light border d-inline-block">
                                <i class="bi bi-file-earmark-arrow-down me-2"></i>
                                <a href="{{ $msg['attachment']['url'] }}" download class="fw-semibold text-primary">{{ $msg['attachment']['name'] }}</a>
                            </div>
                        @endif
                    @endif
                    <div class="text-small text-muted mt-1 text-end">{{ $msg['time'] }}</div>
                </div>
                <img src="{{ $msg['avatar'] }}" class="rounded-circle ms-2 mt-1" width="32" height="32" />
            </div>
        </div>
        @elseif ($msg['sender'] === 'system')
        <div class="chat-divider text-center">
            <div class="d-flex justify-content-center">
                <div class="message system">
                    {{ $msg['message'] }}
                </div>
            </div>
        </div>
        @endif
      @endforeach
    </div>

    <form action="{{ route('Chatsup.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="ticket" value="{{ $selectedTicket->id }}">

      <!-- Image Preview -->
      <div id="selectedImageContainer" class="mb-2">
        <img id="selectedImage" src="" alt="Selected Image" class="img-thumbnail">
        <button type="button" id="removeImage" class="btn btn-sm btn-danger">x</button>
      </div>

      <!-- File Preview -->
      <div id="selectedFileContainer" class="mb-2" style="display:none;">
        <div class="file-box">
          <i class="bi bi-file-earmark-arrow-down me-2"></i>
          <span id="selectedFileName"></span>
          <button type="button" id="removeFile" class="btn btn-sm btn-danger ms-2">x</button>
        </div>
      </div>

      <div class="d-flex align-items-end gap-2 mb-2">
        <textarea class="form-control" name="message" id="messageTextarea" rows="2" placeholder="Type your message..." style="resize: none;"></textarea>

        <button type="submit" class="btn btn-primary rounded px-3 py-2"><i class="bi bi-send-fill"></i></button>

        <button type="button" class="btn d-flex align-items-center gap-2 text-white mark-resolved-btn">
          <i class="bi bi-check-circle-fill fs-5"></i>
          <span class="fw-semibold">Mark as Resolved</span>
        </button>
      </div>

      <div class="d-flex gap-2 pt-1">
        <input type="file" name="attachment[]" id="attachment" class="d-none" multiple>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('attachment').click();">
          <i class="bi bi-paperclip"></i> File
        </button>

        <input type="file" name="image[]" id="image" class="d-none" accept="image/*" multiple>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('image').click();">
          <i class="bi bi-image"></i> Image
        </button>
      </div>
    </form>

    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
          <img id="modalImage" src="" class="img-fluid rounded shadow" />
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/chatdev.js') }}"></script>
<script>
  // Scroll chat body to bottom after render
  document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
      var chatBody = document.getElementById('chatBody');
      if (chatBody) {
        chatBody.scrollTop = chatBody.scrollHeight;
      }
    }, 100);
  });

  // Event delegation untuk gambar yang bisa di klik
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('chat-image-clickable')) {
      var modalImg = document.getElementById('modalImage');
      modalImg.src = e.target.src;
      var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
      imageModal.show();
    }
  });

  // Preview file attachment
  document.getElementById('attachment').addEventListener('change', function(e) {
    const fileInput = e.target;
    const file = fileInput.files[0];
    if (file) {
      document.getElementById('selectedFileName').textContent = file.name;
      document.getElementById('selectedFileContainer').style.display = 'block';
    } else {
      document.getElementById('selectedFileContainer').style.display = 'none';
      document.getElementById('selectedFileName').textContent = '';
    }
  });

  // Cancel file attachment
  document.getElementById('removeFile').addEventListener('click', function() {
    const fileInput = document.getElementById('attachment');
    fileInput.value = '';
    document.getElementById('selectedFileContainer').style.display = 'none';
    document.getElementById('selectedFileName').textContent = '';
  });
</script>
@endsection

