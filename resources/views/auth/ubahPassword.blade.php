@extends('components.authTemplate')

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="d-flex">
                    <form class="login100-form validate-form">
                        <div class="d-flex mb-3 flex-column">
                            <span style="font-size: 2pc; font-weight: bolder;" class="mb-3">
                                Ubah Password
                            </span>
                            <span style="color: #5f5f5f; font-weight: 400" class="">
                                E-mail verifikasi akan dikirim ke mailbox.
                            </span>
                            <span style="color: #5f5f5f; font-weight: 400" class="mb-3">
                                Tolong cek E-mail anda
                            </span>
                        </div>

                        <div class="mb-3">
                            <input placeholder="Password baru" type="password" id="opo" class="form-control rounded-3"
                                id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>


                        <div class="mb-3">
                            <input placeholder="Korfirmasi password" type="email" id="opo" class="form-control rounded-3"
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
