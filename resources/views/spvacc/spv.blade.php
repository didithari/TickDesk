@extends('layout.body')
@section('konten')

<link rel="stylesheet" href="{{asset('assetsadmin')}}/vendor/libs/animate-css/animate.css" />
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assetsadmin')}}/vendor/libs/sweetalert2/sweetalert2.css" />

                  <!-- build:js assets/vendor/js/core.js -->
     <script src="{{asset('assetsadmin')}}/vendor/libs/jquery/jquery.js"></script>
    <script src="{{asset('assetsadmin')}}/vendor/libs/popper/popper.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="{{asset('assetsadmin')}}/js/ui-modals.js"></script>
    <!-- <script src="{{asset('assetsadmin')}}/js/pages-account-settings-account.js"></script> -->
    <script src="{{asset('assetsadmin')}}/vendor/libs/sweetalert2/sweetalert2.js"></script>

      <!-- alert data berhasil -->
  <div class="alert alert-success" role="alert" style="display: none;">Data Akun Telah Ditambahkan!</div>
  <script>
      $(document).ready(function() {
          // Tangkap parameter alert dari URL dan tampilkan alert jika ada
          var urlParams = new URLSearchParams(window.location.search);
          var alertParam = urlParams.get('alert');
          if (alertParam === 'success') {
              $('.alert').fadeIn().delay(5000).fadeOut(); // Tampilkan alert, kemudian hilangkan setelah 5 detik
          }
      });
  </script>

<script>
    function showAlerte() {
        Swal.fire({
            title: 'Fitur Segera Hadir!',
            text: 'Bersabar Yah...',
            icon: 'error',
            showConfirmButton: false,
            timer: 2500
        });
    }
    </script>

<style>

    .ssedtt{
    cursor:pointer;
    }
    
    </style>


<div class="card">
    <div class="card-header">
<div class=" d-flex flex-column mb-3 flex-md-row justify-content-between align-items-center"> <!-- Menambahkan class align-items-center -->
<h2>Supervisor Account</h2>
<div >


    <div class="btn btn-label-primary dropdown-toggle me-2" data-bs-toggle="dropdown" ><i class="ti ti-file-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span></div>
    <button type="button" data-bs-toggle="modal" class="btn btn-primary" data-bs-target="#tambahModal"><i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Tambah Data</span></button>

    <div class="dropdown-menu">
     {{-- <a class="dropdown-item" href="javascript:void(0);" id="printTable"
     ><i class="ti ti-copy me-1" ></i>Copy</a> --}}
     <a class="dropdown-item ssedtt" href="javascript:void(0);" id="csvTable"
     ><i class="ti ti-file-spreadsheet me-1" ></i>Exel</a>
     <a class="dropdown-item ssedtvt" href="javascript:void(0);" id="excelTable"
      ><i class="ti ti-file-text me-1"></i>CSV</a>
      <a class="dropdown-item ssdelee" href="javascript:void(0);" id="pdfTable"
      ><i class="ti ti-file-description me-1"></i>Pdf</a>
      <a class="dropdown-item ssdelee" href="javascript:void(0);"  id="copyTable"
      ><i class="ti ti-printer me-1" ></i>Print</a>
    </div>
</div>
</div>


<div class="table-responsive text-nowrap mb-2">
<table id="table-user" class="table table-hove display">
<thead class="table-light">
  <tr>
    <th>Id</th>
    <th>Username</th>
    <th>name</th>
    <th>status</th>
    <th>created_at</th>
    <th>Aksi</th>
  </tr>
</thead>
<tbody class="table-border-bottom-0 mb-5">
  @foreach ($alldata as $p)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td class="p-3">{{$p->username}}</td>
      <td>{{$p->name}}</td>
      <td>
        @if($p->status === 'active')
          <span class="badge rounded-pill" style="background-color: #d2f4e8; color: #1f7f5c; padding: 6px 12px; font-weight: 600;">Active</span>
        @elseif($p->status === 'Away')
          <span class="badge rounded-pill" style="background-color: #fef3c7; color: #92400e; padding: 6px 12px; font-weight: 600;">Away</span>
        @else
          <span class="badge rounded-pill" style="background-color: #e0e0e0; color: #333; padding: 6px 12px; font-weight: 600;">{{$p->status}}</span>
        @endif
      </td>
      <td>{{$p->created_at}}</td>
      <td>
        <div class="dropdown">
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
            <i class="ti ti-dots-vertical"></i>
          </button>
          <div class="dropdown-menu">
          <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#largeModal{{$p->id}}">
              <i class="ti ti-list-details me-1"></i> Detail Data</button>

            <a class="dropdown-item ssedtt" href="/admin/supervisor/edit-data/{{$p->username}}">
              <i class="ti ti-pencil me-1"></i> Edit Data</a>

              <a class="dropdown-item ssdele" href="javascript:void(0);"
            data-user="{{$p->username}}"
            data-nama="{{$p->name}}">
            <i class="ti ti-trash me-1"></i> Hapus Data
            </a>
          </div>
        </div>
      </td>
    
    </tr>
@endforeach
  @php
      $count = count($alldata);
      $sisa = 4 - ($count % 4);
    @endphp

    @if($sisa < 4)
      @for($i = 0; $i < $sisa; $i++)
        <div class="col-md-3 mb-3"></div>
      @endfor
    @endif
</tbody>

</table >
</div>
</div>

              <!--  Modal Tambah -->
                  <div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <form method="POST" action="/admin/supervisor/tambah-data" enctype="multipart/form-data">
                          @csrf
                          <div class="modal-header">
                            <h3 class="modal-title fw-bold" id="exampleModalLabel3">Tambah Akun Supervisor</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <hr class="my-0 mb-4" />
                              <div class="d-flex align-items-start align-items-sm-center mb-3 gap-4">
                                <img src="" alt="user-avatar" name="upload" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                                <div class="button-wrapper">
                                  <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                    <span class="d-none d-sm-block">Upload Foto Baru</span>
                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" name="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                  </label>
                                  <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                                    <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                  </button>
                                  <div class="text-muted">Diperbolehkan bentuk JPG, GIF atau PNG. Maksimal 5MB</div>
                                </div>
                              </div>

                              <!-- Username -->
                              <div class="col mb-3">
                                <label for="nameLarge" class="form-label">Username</label>
                                <input type="text" name="username" required class="form-control" placeholder="AdminOne" />
                              </div>
                            </div>

                            <!-- Nama -->
                            <div class="row g-2 mb-3">
                              <div class="col mb-0">
                                <label for="dobLarge" class="form-label">Nama</label>
                                <input type="text" id="inputHuruf" oninput="validateInput(this)" name="nama" required class="form-control" placeholder="Admin One" />
                                <span id="error-message" style="color: cyan;"></span>
                              </div>
                            </div>

                            <!-- Email & No HP -->
                            <div class="row g-2 mb-3">
                              <div class="col mb-0">
                                <label for="emailInput" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required placeholder="example@mail.com" />
                              </div>

                              <div class="col mb-0">
                                <label for="phoneNumber" class="form-label">No HP</label>
                                <div class="input-group input-group-merge">
                                  <span class="input-group-text">+62</span>
                                  <input type="number" name="nohp" class="form-control" pattern="[0-9]{10,13}" required placeholder="81234567890" />
                                </div>
                              </div>
                            </div>

                            <!-- Hidden datetime -->
                            <input type="datetime-local" id="tgl" hidden name="tgl" />

                            <!-- Password -->
                            <div class="row g-2 mb-3">
                              <div class="col mb-0">
                                <div class="form-password-toggle">
                                  <label class="form-label" for="basic-default-password12">Password</label>
                                  <div class="input-group">
                                    <input
                                      type="password"
                                      name="pass"
                                      class="form-control"
                                      id="basic-default-password12"
                                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                      aria-describedby="basic-default-password2" />
                                    <span id="basic-default-password2" class="input-group-text cursor-pointer">
                                      <i class="ti ti-eye-off"></i>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>

                          <!-- Footer -->
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary me-2">Tambah Data</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!--  End Modal Tambah -->

                  <script>
                    // Fungsi untuk mengatur nilai elemen input datetime-local menjadi tanggal dan waktu saat ini
                    function setDateTime() {
                        var now = new Date(); // Mendapatkan tanggal dan waktu saat ini
                        var year = now.getFullYear();
                        var month = (now.getMonth() + 1).toString().padStart(2, '0'); // Bulan dimulai dari 0
                        var day = now.getDate().toString().padStart(2, '0');
                        var hours = now.getHours().toString().padStart(2, '0');
                        var minutes = now.getMinutes().toString().padStart(2, '0');
                        var dateTimeString = year + '-' + month + '-' + day + 'T' + hours + ':' + minutes;
                        document.getElementById('tgl').value = dateTimeString; // Mengatur nilai elemen input
                    }
            
                    // Panggil fungsi setDateTime saat halaman dimuat
                    setDateTime();
                </script>




                  <!-- Detail Modal -->
                  @foreach ($alldata as $p)
                  <div class="modal fade" id="largeModal{{$p->id}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalLabel3">Detail Akun</h3>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <br>
                        <hr class="my-0" />
                        <div class="modal-body">
                          <div class="d-flex align-items-start align-items-sm-center mb-3 gap-4">
                            <img
                              src="{{ $p->profile_picture ?? asset('assetsadmin/img/avatars/default.png') }}"
                              alt="user-avatar"
                              class="d-block w-px-100 h-px-100 rounded"
                              id="uploadedAvatar" />
                          </div>

                          <!-- Username -->
                          <div class="row">
                            <div class="col mb-3">
                              <label for="nameLarge" class="form-label">Username</label>
                              <input type="text" readonly class="form-control" placeholder="" value="{{$p->username}}" />
                            </div>
                          </div>

                          <!-- Nama -->
                          <div class="row g-2 mb-3">
                            <div class="col mb-0">
                              <label for="dobLarge" class="form-label">Nama</label>
                              <input type="text" readonly class="form-control" placeholder="" value="{{$p->name}}" />
                            </div>
                          </div>

                          <!-- Email dan No HP -->
                          <div class="row g-2 mb-3">
                            <div class="col mb-0">
                              <label for="email" class="form-label">Email</label>
                              <input type="text" readonly class="form-control" value="{{$p->email ?? '-'}}" />
                            </div>
                            <div class="col mb-0">
                              <label for="nohp" class="form-label">No HP</label>
                              <input type="text" readonly class="form-control" value="{{$p->phone_number ?? '-'}}" />
                            </div>
                          </div>

                          <!-- Status dan lainnya -->
                          <div class="row g-2 mb-3">
                            <div class="col mb-0">
                              <label for="emailLarge" class="form-label">Status</label>
                              <input type="text" value="{{$p->status}}" readonly class="form-control" placeholder="" />
                            </div>
                          </div>
                          <div class="row g-2 mb-3">
                            <div class="col mb-0">
                              <label for="emailLarge" class="form-label">Tanggal Create</label>
                              <input type="datetime" class="form-control" value="{{$p->created_at}}" readonly placeholder="" />
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  <!-- End Detail Modal -->
               


<style>
.ssdele:hover{
background-color:#DE3163;
color:#eaeaea;
}

.ssdelee:hover{
background-color:#DE3163;
color:#eaeaea;
}

.ssedtt:hover{
background-color:#53B956;
color:#eaeaea;
}
.ssedtvt:hover{
background-color:#EAE041;
color: #fff;;
}
#table-controls {
margin-bottom: 10px;
}

/* Menyembunyikan tombol-tombol JS bawaan DataTables */
.dt-buttons {
display: none;
z-index: 100;
}

div.dataTables_length {
float: left;
}
div.dataTables_filter {
float: right;
}


div.dataTables_info {
float: left;
}
div.dataTables_paginate {
float: right;
}

</style>


<script>

function validateInput(inputElement) {
  const inputValue = inputElement.value;
  const forbiddenCharacters = /[@1234567890!#^&*]/g; // Karakter yang tidak diinginkan

  if (forbiddenCharacters.test(inputValue)) {
    document.getElementById('error-message').textContent = 'Tidak boleh mengandung karakter tertentu, seperti @, angka, atau karakter lainnya.';
    inputElement.value = inputValue.replace(forbiddenCharacters, ''); // Menghapus karakter yang tidak diinginkan
  } else {
    document.getElementById('error-message').textContent = '';
  }
}


document.addEventListener('DOMContentLoaded', function () {
(function () {
// Update/reset user image on the account page
const accountUserImage = document.getElementById('uploadedAvatar');
const fileInput = document.querySelector('.account-file-input');
const resetFileInput = document.querySelector('.account-image-reset');

if (accountUserImage) {
  const resetImage = accountUserImage.src;

  fileInput.onchange = () => {
    if (fileInput.files[0]) {
      accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
    }
  };

  resetFileInput.onclick = () => {
    fileInput.value = '';
    accountUserImage.src = resetImage;
  };
}
})();
});

</script>



<script>
$(document).ready(function() {
  $('.ssdele').click(function() {
      var user = $(this).data('user');
      var nama = $(this).data('nama');

      Swal.fire({
  title: 'Apakah Anda yakin ingin menghapus data nama ' + user + '?',
  text: "Tindakan ini tidak dapat dibatalkan!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  confirmButtonText: 'Ya, Hapus Data!',
  cancelButtonText: 'Tidak',
  showClass: {
      popup: 'animate__animated animate__tada'
  },
  customClass: {
      confirmButton: 'btn btn-primary me-3',
      cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
}).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                  type: 'DELETE', // Ubah method menjadi DELETE
                  url: '/admin/supervisor/user/hapus-akun/' + user,
                  data: {
                      _token: '{{ csrf_token() }}'
                  },
                  success: function(response) {
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2500
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1800
                        }).then(() => {
                            window.location.href = "{{ route('akun.supervisor') }}";
                        });
                    }
                },
                  error: function(xhr, status, error) {
                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: xhr.responseText
                      });
                  }
              });
          }
      });
  });
});
</script>



<script>

document.addEventListener('DOMContentLoaded', function (e) {
(function () {
// Update/reset user image of account page
const accountUserImage = document.getElementById('uploadedAvatar');
const fileInput = document.querySelector('.account-file-input');
const resetFileInput = document.querySelector('.account-image-reset');

if (accountUserImage) {
  const resetImage = accountUserImage.src;

  fileInput.onchange = () => {
    if (fileInput.files[0]) {
      accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
    }
  };

  resetFileInput.onclick = () => {
    fileInput.value = '';
    accountUserImage.src = resetImage;
  };
}
})();
});



$(document).ready(function() {
// Inisialisasi DataTables
var table = $('#table-user').DataTable({
    "language": {
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        "paginate": {
            "previous": "Sebelumnya",
            "next": "Selanjutnya"
        },
    },
    "format": {
        body: function (inner, coldex, rowdex) {
            if (!inner) return inner;
            var el = $.parseHTML(inner);
            var result = '';

            el.forEach(function (item) {
                if (item.classList !== undefined && item.classList.contains('user-name')) {
                    result += item.textContent;
                } else {
                    result += item.innerText || item.textContent;
                }
            });

            return result;
        },
    },
    "lengthMenu": [10, 25, 50],
    dom: '<"top"Blfr>t<"bottom"ip>',
});


// Hapus tombol-tombol JS yang ingin Anda sembunyikan
$('.dt-button').remove();

// Tambahkan fungsi klik untuk tombol dropdown menu ke tombol DataTables yang sudah ada
$("#printTable").on('click', function() {
    table.button('0').trigger();
});
$("#csvTable").on('click', function() {
    table.button('1').trigger();
});
$("#excelTable").on('click', function() {
    table.button('2').trigger();
});
$("#pdfTable").on('click', function() {
    table.button('3').trigger();
});
$("#copyTable").on('click', function() {
    table.button('4').trigger();
});
});
</script>

                          {{-- <div class="col mb-0">
                              
                          <label class="form-label" for="phoneNumber">No HP</label>
                        <div class="input-group input-group-merge">
                          <span class="input-group-text">ID (+62)</span>
                          <input
                            type="number"
                             required
                            name="nohp"
                            class="form-control"
                            placeholder="" />
                        </div>
                          
                            </div> --}}


@endsection