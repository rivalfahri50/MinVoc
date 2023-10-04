@extends('auth.components.authTemplate')

@section('content')
    <style>
        .labelcontainer {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            gap: 5px;
        }

        .ikon {
            width: fit-content; 
            padding-right: 0; 
            font-size: 1.2rem;
        }

        .tek {
            width: fit-content; 
            padding-left: 0;
        }
    </style>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" class="d-flex  flex-column">
                <div class="d-flex">
                    <form class="login100-form validate-form" action="{{ route('storeSignUp') }}" method="POST">
                        @csrf
                        <div class="box">
                            <div class="d-flex flex-column">
                                <span style="font-size: 2pc; font-weight: bolder;" class="mb-3">
                                    Buat Akun
                                </span>
                                <span style="color: #5f5f5f; font-weight: 400" class="mb-3">
                                    Selamat datang di <span style="color: #957DAD; font-weight: 600">MusiCave</span>
                                </span>
                            </div>

                            @if (session()->has('failed'))
                                <div class="mb-4" style="font-size: 14px; width: 60%; color: red; font-weight: bolder"
                                    role="alert">
                                    {{ session('failed') }}
                                </div>
                            @endif

                            <div class="d-flex mt-2 mb-4" style="gap: 15px">
                                <div class="container-login100-form-btn">
                                    <span id="button1" style="width: 100%" class="login100-form-btn rounded-4 selected">
                                        <input type="radio" id="pengguna" name="role" value="pengguna">
                                        <label for="pengguna" class="row labelcontainer">
                                            <div class="ikon">
                                                <i class="fa-solid fa-headphones"></i>
                                            </div>
                                            <div class="tek">Pengguna</div>
                                        </label>
                                    </span>
                                </div>
                                {{-- <input type="radio" name="role" placeholder="admin" value="admin"> --}}
                                <div class="container-login100-form-btn">
                                    <span id="button2" style="width: 100%"
                                        class="login100-form-btn d-flex gap-3 rounded-4 selected">
                                        <input type="radio" id="artis" name="role" value="artis">
                                        <label for="artis" class="row labelcontainer">
                                            <div class="ikon">
                                                <i class="fas fa-microphone-alt"></i>
                                            </div>
                                            <div class="tek">
                                                Artis
                                            </div>
                                        </label>
                                    </span>
                                </div>
                            </div>

                            @error('role')
                                <div class="mb-2 text-danger">{{ $message }}</div>
                            @enderror

                            <div class="mb-3">
                                <input placeholder="Nama pengguna" name="name" type="text"
                                    class="form-control rounded-3" id="exampleInputEmail1" aria-describedby="emailHelp"
                                    value="{{ old('name') }}" maxlength="55">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input placeholder="Email" name="email" type="email" class="form-control rounded-3"
                                    id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('email') }}"
                                    maxlength="55">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input placeholder="Kata Sandi" name="password" type="password"
                                    class="form-control rounded-3" id="exampleInputEmail1" aria-describedby="emailHelp"
                                    value="{{ old('password') }}" maxlength="55">
                            </div>

                            <div class="mb-3">
                                <input placeholder="Konfirmasi Kata Sandi" name="password_confirmation" type="password"
                                    class="form-control rounded-3" id="exampleInputEmail1" aria-describedby="emailHelp"
                                    value="{{ old('password_confirmation') }}" maxlength="55">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex-sb-m w-full p-t-3 p-b-32">
                                <div style="color: black; font-weight: 600; font-size: 13px">
                                    <span>sudah punya akun? klik <a href="{{ route('pengguna') }}"
                                            style="font-weight: 600; color: #957DAD; text-decoration: none">masuk</a></span>
                                </div>
                            </div>

                            <div class="container-login100-form-btn">
                                <button class="login100">
                                    Daftar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="login100-more" style="padding-top: 40px">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="/image/logo.svg" alt="" srcset="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const button1 = document.querySelector('#button1');
        const button2 = document.querySelector('#button2');
        const svg1 = document.querySelectorAll('.svg1');
        const svg2 = document.querySelectorAll('.svg2');

        button1.addEventListener('click', toggleSelected)
        button2.addEventListener('click', toggleSelected)

        function toggleSelected(event) {
            if (event.currentTarget == button1) {
                button1.classList.remove('button');
                button1.classList.add('buttonSelected');
                button2.classList.add('border');
                button1.classList.remove('border');
                svg1.classList.add('button');
            } else if (event.currentTarget == button2) {
                button2.classList.remove('button');
                button2.classList.add('buttonSelected');
                button1.classList.add('border');
                button2.classList.remove('border');
                svg2.classList.add('button');
            }
        }
    </script>
@endsection
