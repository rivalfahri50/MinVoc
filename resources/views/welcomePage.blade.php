@extends('auth.components.authTemplate')

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-more" style="padding-top: 40px">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="/image/welcomeLogo.svg" alt="" srcset="">
                    </div>
                </div>

                <div class="d-flex align-content-center">
                    <div class="login100-form d-flex flex-column gap-5" style="justify-content: space-evenly">
                        <div class="d-flex mb-3 gap-5 flex-column">
                            <span style="font-size: 2pc; color: #5D4575; font-weight: bolder" class="mb-3">
                                Selamat datang di <span style="color: #957DAD">MusiCave</span>
                            </span>
                            <span style="color: #5D4575; font-weight: 500;" class="mb-3 fs-4 text">
                                Platform musik yang menghadirkan pengalaman mendengarkan tak terlupakan Di sini
                            </span>
                        </div>

                        <div class="d-flex gap-4 mb-4 flex-column" style="width: 80%">
                            <div class="d-flex flex-row flex-wrap gap-3">
                                <div class="container-login100-form-btn" style="width: 40%">
                                    <button id="user_pengguna" class="selected login100-form-btn rounded-4"
                                        style="font-weight: bolder; gap: 10px;">
                                        <div style="font-size: 23px">
                                            <i class="mdi mdi-chevron-double-right"></i>
                                        </div>
                                        Masuk
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const pengguna = document.querySelector('#user_pengguna')
        const admin = document.querySelector('#user_admin')

        pengguna.addEventListener('click', () => {
            window.location = '{{ route('pengguna') }}';
        })

        admin.addEventListener('click', () => {
            window.location = '{{ route('pengguna') }}';
        })
    </script>
@endsection
