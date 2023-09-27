@extends('auth.components.authTemplate')

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="d-flex">
                    <form class="login100-form validate-form" action="{{ route('storeSignIn') }}" method="POST">
                        @csrf
                        <div class="d-flex mb-3 flex-column">
                            <span style="font-size: 2pc; font-weight: bolder;" class="mb-3">
                                Masuk
                            </span>
                            <span style="color: #5f5f5f; font-weight: 400" class="mb-3">
                                Selamat datang di <span style="color: #957DAD; font-weight: 600">MusiCave</span>
                            </span>
                        </div>

                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session()->has('failed'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('failed') }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <input name="email" placeholder="Email" type="text" class="form-control rounded-3"
                                id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <div class="text-danger mt-1 my-1">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <input name="password" placeholder="Kata Sandi" type="password" class="form-control rounded-3"
                                id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('password') }}">
                            @if ($errors->has('password'))
                                <div class="text-danger mt-1 my-1">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="flex-sb-m w-full p-t-3 p-b-32">
                            <div class="contact100-form-checkbox">
                                <input class="input-checkbox100" id="ckb1" type="checkbox" name="kebijakan_privasi">
                                <label class="label-checkbox100" for="ckb1">
                                    <a href="/kebijakan-privasi" style="text-decoration: none;">
                                        <span>Kebijakan Privasi</span>
                                    </a>
                                </label>

                                @error('kebijakan_privasi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                   
                            <div>
                                <a style="text-decoration: none; font-family: Poppins" href="{{ route('lupaSandi') }}"
                                    class="txt1">
                                    Tidak Ingat Kata Sandi
                                </a>
                            </div>
                        </div>

                        <div class="container-login100-form-btn">
                            <button class="login100">
                                Masuk
                            </button>
                        </div>

                        <div class="flex-sb-m w-full p-t-3 p-b-32 mt-4">
                            <div style="color: black; font-weight: 600; font-size: 13px">
                                <span>belum punya akun? klik <a href="/buat-akun"
                                        style="font-weight: 600; color: #957DAD; text-decoration: none">daftar</a></span>
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
        document.addEventListener('DOMContentLoaded', function() {
            const dataKey = 'dataKey';
            const checkbox = document.querySelector('#ckb1');

            const storedData = localStorage.getItem(dataKey);

            if (storedData !== null) {
                checkbox.checked = true;
                console.log('Data ditemukan:', storedData);

                const dataElement = document.getElementById('dataElement');
                if (dataElement) {
                    dataElement.textContent = storedData;
                }
            } else {
                console.log('Data tidak ditemukan.');
            }
        });

        window.addEventListener('unload', function() {
            const dataKey = 'dataKey';

            localStorage.removeItem(dataKey);
        });
    </script>
@endsection
