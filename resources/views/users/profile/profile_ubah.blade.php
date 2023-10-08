@extends('users.components.usersTemplates')

@section('content')
    <style>
        .cobai {
            width: 130px;
            height: 130px;
            border-radius: 100px;
            position: relative;
            overflow: hidden;
            border: none;
            color: #957DAD;
        }

        .cob {
            display: flex;
            justify-content: center;
            align-items: center;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
        }

        .cob img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }



        .upload-label i {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .form-i {
            height: 25px;
            border-radius: 8px;
        }
    </style>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 stretch-card">
                    <h4 style="font-size: 20px; font-weight: 600; color: #957dad">Profil</h4>
                    <p style="font-size: 0.995rem;">Atur akun anda, Semua perubahan akan di aplikasikan ke semua halaman</p>
                </div>
                <form class="row" action="{{ route('update.profile', $user[0]->code) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-2">
                        <div class="mb-3">
                            <h4 style="font-size: 20px; font-weight: 600; color: #957dad">Foto profil</h4>
                            <div class="rounded-circle">
                                <label id="tampil_gambar" class="cobai cob">
                                    <img id="profile-image" src="{{ asset('storage/' . $user[0]->avatar) }}"
                                        class="rounded-circle" width="150" height="150">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 tengahvertical">
                        <div>
                            <input type="file" id="gambar" accept="image/*" name="avatar"
                                class="form-control" onchange="previewImage()">
                            @if ($errors->has('avatar'))
                                <div class="text-danger mt-1 my-1" style="width: 200px">
                                    {{ $errors->first('avatar') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label"
                                style="font-size: 20px; font-weight: 600; color: #957dad">Nama pengguna</label>
                            <input type="text" class="form-control" name="name" id="name" aria-describedby="namaFeedback" maxlength="55">
                            @if ($errors->has('name'))
                                <div class="text-danger mt-1 my-1">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label"
                                style="font-size: 20px; font-weight: 600; color: #957dad">Email</label>
                            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailFeedback" maxlength="55">
                            @if ($errors->has('email'))
                                <div class="text-danger mt-1 my-1">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label"
                                style="font-size: 20px; font-weight: 600; color: #957dad">Deskripsi</label>
                            <textarea id="deskripsiUser" class="form-control" name="deskripsi" maxlength="500" rows="5"></textarea>
                            <div id="counter" class="float-right"></div>
                        </div>
                    </div>
                    <div class="col-1">
                        <button class="btn" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script>
        const code = "{{ auth()->user()->id }}"
        console.log(code);
        fetch(`/pengguna/profile/${code}`)
            .then(response => response.json())
            .then(data => {
                const name = document.getElementById('name');
                const email = document.getElementById('email');
                const deskripsi = document.getElementById('deskripsiUser');

                name.value = data.user.name;
                email.value = data.user.email;
                if (data.user.deskripsi == "none") {
                    deskripsi.innerHTML = '';
                } else {
                    deskripsi.innerHTML = data.user.deskripsi;
                }

                const event = new Event('input', {
                    bubbles: true
                });
                name.dispatchEvent(event);
                email.dispatchEvent(event);
                deskripsi.dispatchEvent(event);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });

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


        const gambar = document.querySelector("#gambar");
        const tampilGambar = document.querySelector("#tampil_gambar");
        gambar.addEventListener("change", function() {
            const reader = new FileReader();

            reader.addEventListener("load", () => {
                tampilGambar.style.backgroundImage = `url(${reader.result})`;

                tampilGambar.innerHTML = "";
            });

            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
