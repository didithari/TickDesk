@extends('layout.body')
@section('konten')

<div class="container py2 px-0"> {{-- Memberi jarak luar --}}

<link rel="stylesheet" href="{{asset('assetsadmin')}}/vendor/libs/animate-css/animate.css" />
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assetsadmin')}}/vendor/libs/sweetalert2/sweetalert2.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


<script src="{{asset('assetsadmin')}}/vendor/libs/jquery/jquery.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('assetsadmin')}}/vendor/libs/sweetalert2/sweetalert2.js"></script>

<div class="card p-4"> {{-- Tambahkan padding dalam card --}}

    <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-1 mb-1">
        <h2>Data Role</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Role</button>
    </div>

    <div class="table-responsive text-nowrap">
        <table id="table-role" class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nama Role</th>
                    <th>Create_at</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->idRole }}</td>
                    <td>{{ $role->namaRole }}</td>
                    <td>{{ $role->created_at }}</td>
                    <td>
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu">
                    <!-- Tombol Edit -->
                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal{{ $role->idRole }}">
                        <i class="ti ti-pencil me-1"></i> Edit
                    </button>

                    <!-- Tombol Hapus -->
                    <form action="{{ route('role.delete', $role->idRole) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger">
                        <i class="ti ti-trash me-1"></i> Hapus
                        </button>
                    </form>
                    </div>
                </div>
                </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal{{ $role->idRole }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('role.update', $role->idRole) }}">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Role</h5>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $role->idRole }}" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama Role</label>
                                        <input type="text" name="namaRole" value="{{ $role->namaRole }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('role.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Role</label>
                        <input type="text" name="namaRole" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#table-role').DataTable();
    });
</script>

</div> {{-- Tutup container --}}

@endsection
