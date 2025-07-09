@extends('layout.body')
@section('konten')

<div class="">
    <div class="card">
        <div class="card-header">
            <h4>Edit Data Akun Supervisor</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="/admin/supervisor/update-data/{{$akun->username}}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ $akun->username }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $akun->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="upload" class="form-label">Foto Profil</label><br>
                    <img id="previewImg" src="{{ $akun->imgProfile ?? asset('assetsadmin/img/avatars/default.png') }}" class="img-thumbnail mb-2" width="100">
                    <input type="file" name="upload" class="form-control" onchange="previewImage(this)">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('akun.supervisor') }}" class="btn btn-secondary">Batal</a>
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
