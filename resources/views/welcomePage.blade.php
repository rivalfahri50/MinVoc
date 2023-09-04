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
                                        style="font-weight: bolder">
                                        <span>
                                            <svg class="mt-2 selected" width="38" height="30" viewBox="0 0 40 38"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path class="selected svg1"
                                                    d="M19.8634 17.4167C21.173 17.4167 22.4531 17.0452 23.5419 16.3493C24.6308 15.6534 25.4795 14.6643 25.9806 13.507C26.4817 12.3497 26.6129 11.0763 26.3574 9.84776C26.1019 8.61922 25.4713 7.49073 24.5453 6.60499C23.6193 5.71926 22.4395 5.11607 21.1551 4.8717C19.8707 4.62732 18.5394 4.75274 17.3296 5.2321C16.1197 5.71145 15.0856 6.52321 14.3581 7.56472C13.6305 8.60624 13.2422 9.83072 13.2422 11.0833C13.2422 12.763 13.9398 14.3739 15.1815 15.5617C16.4232 16.7494 18.1073 17.4167 19.8634 17.4167Z" />
                                                <path class="selected svg1"
                                                    d="M29.7953 33.2499C30.2343 33.2499 30.6554 33.0831 30.9658 32.7862C31.2762 32.4892 31.4506 32.0865 31.4506 31.6666C31.4506 28.7271 30.2298 25.908 28.0568 23.8295C25.8838 21.751 22.9366 20.5833 19.8635 20.5833C16.7904 20.5833 13.8432 21.751 11.6702 23.8295C9.49715 25.908 8.27637 28.7271 8.27637 31.6666C8.27637 32.0865 8.45077 32.4892 8.76119 32.7862C9.07162 33.0831 9.49266 33.2499 9.93167 33.2499H29.7953Z" />
                                            </svg>

                                        </span>
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
