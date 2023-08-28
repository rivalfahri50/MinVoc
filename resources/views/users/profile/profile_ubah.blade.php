@extends('users.components.usersTemplates')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 stretch-card">
                    <h4 style="font-size: 20px; font-weight: 600; color: #957dad">Profil</h4>
                    <p>Atur akun anda, Semua perubahan akan di aplikasikan ke semua halaman</p>
                </div>
                <form class="row" action="{{ route('update.profile', $user[0]->code) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-2">
                        <div class="mb-3">
                            <h4 style="font-size: 20px; font-weight: 600; color: #957dad">Foto profil</h4>
                            <img src="{{ asset('storage/' . $user[0]->avatar) }}" class="rounded-circle" width="100px">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-5">
                            <input type="file" id="foto" name="avatar" class="form-control"
                                aria-label="file example">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label"
                                style="font-size: 20px; font-weight: 600; color: #957dad">Nama pengguna</label>
                            <input type="text" class="form-control" name="name" id="nama"
                                value="{{ $user[0]->name }}" aria-describedby="validationServer03Feedback">
                            @error('name')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label"
                                style="font-size: 20px; font-weight: 600; color: #957dad">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="{{ $user[0]->email }}" required>
                            @error('email')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label"
                                style="font-size: 20px; font-weight: 600; color: #957dad">Deskripsi</label>
                            <textarea id="deskripsi" class="form-control" name="deskripsi" maxlength="500" rows="5">{{ $user[0]->deskripsi === 'none' ? '' : $user[0]->deskripsi }}</textarea>
                            <div id="counter" class="float-right"></div>
                        </div>
                    </div>
                    <div class="col-1">
                        <button class="btn" type="submit">Simpan</button>
                    </div>
                    <div class="col-1">
                        <a href="/pengguna/profile" class="btn btn-danger" type="submit">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script>
        const messageEle = document.getElementById('deskripsi');
        const counterEle = document.getElementById('counter');
        messageEle.addEventListener('input', function(e) {
            const target = e.target;
            // Get the `maxlength` attribute
            const maxLength = target.getAttribute('maxlength');
            // Count the current number of characters
            const currentLength = target.value.length;
            counterEle.innerHTML = `${currentLength}/${maxLength}`;
        });
    </script>
@endsection
