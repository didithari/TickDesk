@extends('layout.body')
@section('konten')

<div class="">
    <div class="card">
        <div class="card-header">
            <h4>Edit Data Akun Developer</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="/akun/update-data/{{$akun->username}}" enctype="multipart/form-data">
                @csrf

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ $akun->username }}" readonly>
                </div>

                <!-- Nama -->
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $akun->name }}" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $akun->email ?? '' }}" required>
                </div>

                <!-- No HP -->
                <div class="mb-3">
                    <label for="nohp" class="form-label">No HP</label>
                    <input type="text" name="nohp" class="form-control" value="{{ $akun->phone_number ?? '' }}" required>
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $akun->devRoleID == $role->id ? 'selected' : '' }}>
                                {{ $role->roleName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Foto Profil -->
                <div class="mb-3">
                    <label for="upload" class="form-label">Foto Profil</label><br>
                    <img id="previewImg" src="{{ $akun->profile_picture ?? asset('assetsadmin/img/avatars/default.png') }}" class="img-thumbnail mb-2" width="100">
                    <input type="file" name="upload" class="form-control" onchange="previewImage(this)">
                </div>

                <!-- Tombol -->
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('akunadmin') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('previewImg');
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
        }
    }
</script>

@endsection
