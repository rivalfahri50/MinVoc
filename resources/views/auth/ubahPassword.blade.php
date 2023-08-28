<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link rel="shortcut icon" href="images/favicon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet" href="http://127.0.0.1:8000/css/styles.css">
    <link rel="stylesheet" type="text/css"
        href="http://127.0.0.1:8000/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="http://127.0.0.1:8000/css/util.css">
    <link rel="stylesheet" type="text/css" href="http://127.0.0.1:8000/css/main.css">
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="d-flex">
                    <form class="login100-form validate-form" action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <div class="d-flex mb-3 flex-column">
                            <input type="hidden" name="token" value="{{ request()->token }}">
                            <input type="hidden" name="email" value="{{ request()->email }}">
                            <span style="font-weight: bolder;" class="mb-3 fs-2">
                                Ubah Password
                            </span>
                            <span style="color: #5f5f5f; font-weight: 400" class="">
                                E-mail verifikasi akan dikirim ke mailbox.
                            </span>
                            <span style="color: #5f5f5f; font-weight: 400" class="mb-3">
                                Tolong cek E-mail anda
                            </span>
                        </div>


                        @if (session()->has('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @error('password')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        <div class="mb-3">
                            <input name="password" placeholder="Password baru" type="password" id="opo"
                                value="{{ old('password') }}" class="form-control rounded-3" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                        </div>

                        @error('password_confirmation')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        <div class="mb-3">
                            <input name="password_confirmation" placeholder="Korfirmasi password" type="password"
                                value="{{ old('password_confirmation') }}" id="opo" class="form-control rounded-3"
                                id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>

                        <div class="container-login100-form-btn mb-3 mt-5">
                            <button class="login100 rounded-4">
                                Kirim
                            </button>
                        </div>
                        <div class="container-login100-form-btn">
                            <button id="button" class="login100 rounded-4">
                                Kembali
                            </button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
    </script>
</body>

</html>
