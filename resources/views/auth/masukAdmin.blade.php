@extends('components.authTemplate')

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="d-flex">
                    <form class="login100-form validate-form" action="{{ route('storeSignIn.admin') }}" method="POST">
                        @csrf
                        <div class="d-flex mb-3 flex-column">
                            <span style="font-size: 2pc; font-weight: bolder;" class="mb-3">
                                Masuk
                            </span>
                            <span style="color: #5f5f5f; font-weight: 400" class="mb-3">
                                Selamat datang admin di <span style="color: #957DAD; font-weight: 600">MusiCave</span>
                            </span>
                        </div>

                        @error('name')
                            <div class="mb-2">{{ $message }}</div>
                        @enderror
                        <div class="mb-3">
                            <input name="name" placeholder="Nama pengguna" type="text" class="form-control rounded-3"
                                id="exampleInputEmail1" aria-describedby="emailHelp" autofocus>
                        </div>

                        @error('passwordF')
                            <div class="mb-2">{{ $message }}</div>
                        @enderror
                        <div class="mb-3">
                            <input name="password" placeholder="Kata Kunci" type="password" class="form-control rounded-3"
                                id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>

                        <div class="flex-sb-m w-full p-t-3 p-b-32">
                            <div class="contact100-form-checkbox">
                                <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                                <label class="label-checkbox100" for="ckb1">
                                    Kebijakan Privasi
                                </label>
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
                    </form>
                </div>

                <div class="login100-more" style="padding-top: 40px">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="/images/logo.svg" alt="" srcset="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    </body>

    </html>
@endsection
