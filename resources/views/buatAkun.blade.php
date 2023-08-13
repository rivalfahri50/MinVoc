@extends('components.authTemplate')

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" class="d-flex  flex-column">
                <div class="d-flex">
                    <form class="login100-form validate-form">
                        <div class="d-flex mb-3 flex-column">
                            <span style="font-size: 2pc; font-weight: bolder;" class="mb-3">
                                Buat Akun
                            </span>
                            <span style="color: #5f5f5f; font-weight: 400" class="mb-3">
                                Selamat datang di <span style="color: #957DAD; font-weight: 600">MusiCave</span>
                            </span>
                        </div>

                        <div class="d-flex gap-4 mb-4">
                            <div class="container-login100-form-btn">
                                <button id="button" class="login100-form-btn rounded-4">
                                    <span>
                                        <svg width="40" height="38" viewBox="0 0 40 38" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M19.8634 17.4167C21.173 17.4167 22.4531 17.0452 23.5419 16.3493C24.6308 15.6534 25.4795 14.6643 25.9806 13.507C26.4817 12.3497 26.6129 11.0763 26.3574 9.84776C26.1019 8.61922 25.4713 7.49073 24.5453 6.60499C23.6193 5.71926 22.4395 5.11607 21.1551 4.8717C19.8707 4.62732 18.5394 4.75274 17.3296 5.2321C16.1197 5.71145 15.0856 6.52321 14.3581 7.56472C13.6305 8.60624 13.2422 9.83072 13.2422 11.0833C13.2422 12.763 13.9398 14.3739 15.1815 15.5617C16.4232 16.7494 18.1073 17.4167 19.8634 17.4167Z"
                                                fill="#957DAD" />
                                            <path
                                                d="M29.7953 33.2499C30.2343 33.2499 30.6554 33.0831 30.9658 32.7862C31.2762 32.4892 31.4506 32.0865 31.4506 31.6666C31.4506 28.7271 30.2298 25.908 28.0568 23.8295C25.8838 21.751 22.9366 20.5833 19.8635 20.5833C16.7904 20.5833 13.8432 21.751 11.6702 23.8295C9.49715 25.908 8.27637 28.7271 8.27637 31.6666C8.27637 32.0865 8.45077 32.4892 8.76119 32.7862C9.07162 33.0831 9.49266 33.2499 9.93167 33.2499H29.7953Z"
                                                fill="#957DAD" />
                                        </svg>

                                    </span>
                                    Pengguna
                                </button>
                            </div>
                            <div class="container-login100-form-btn">
                                <button class="login100-form-btn d-flex gap-3 rounded-4">
                                    <span>
                                        <svg style="margin-top: 8px" width="27" height="34" viewBox="0 0 27 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M25.7916 11.9416C25.1183 11.9416 24.5831 12.4615 24.5831 13.1157V15.7659C24.5831 21.7036 19.6113 26.5343 13.5 26.5343C7.38874 26.5343 2.41688 21.7036 2.41688 15.7659V13.0989C2.41688 12.4448 1.88171 11.9248 1.20844 11.9248C0.535166 11.9248 0 12.4448 0 13.0989V15.7491C0 22.5758 5.40345 28.1949 12.2916 28.7987V32.3714C12.2916 33.0256 12.8267 33.5455 13.5 33.5455C14.1733 33.5455 14.7084 33.0256 14.7084 32.3714V28.7987C21.5793 28.2116 27 22.5758 27 15.7491V13.0989C26.9827 12.4615 26.4476 11.9416 25.7916 11.9416Z" fill="white"/>
                                            <path d="M13.4976 0C9.28536 0 5.86719 3.3211 5.86719 7.41377V16.0017C5.86719 20.0943 9.28536 23.4154 13.4976 23.4154C17.7099 23.4154 21.128 20.0943 21.128 16.0017V7.41377C21.128 3.3211 17.7099 0 13.4976 0ZM15.7591 11.6574C15.6382 12.0935 15.2412 12.3786 14.7923 12.3786C14.706 12.3786 14.6197 12.3619 14.5334 12.3451C13.8601 12.1606 13.1523 12.1606 12.479 12.3451C11.9266 12.4961 11.3914 12.1774 11.2533 11.6574C11.098 11.1374 11.426 10.6007 11.9611 10.4665C12.9797 10.1981 14.05 10.1981 15.0686 10.4665C15.5865 10.6007 15.8972 11.1374 15.7591 11.6574ZM16.6741 8.40339C16.5187 8.80595 16.1389 9.04077 15.7246 9.04077C15.6037 9.04077 15.5001 9.024 15.3793 8.99045C14.1709 8.55435 12.8243 8.55435 11.6159 8.99045C11.098 9.17496 10.511 8.90659 10.3211 8.40339C10.1312 7.90019 10.4074 7.3299 10.9253 7.16217C12.5826 6.57511 14.4125 6.57511 16.0698 7.16217C16.5877 7.34668 16.8639 7.90019 16.6741 8.40339Z" fill="white"/>
                                            </svg>
                                            
                                    </span>
                                    Artis
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <input placeholder="Nama pengguna" type="email" class="form-control rounded-3"
                                id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>

                        <div class="mb-3">
                            <input placeholder="Email" type="email" class="form-control rounded-3"
                                id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>

                        <div class="mb-3">
                            <input placeholder="Kata Kunci" type="email" class="form-control rounded-3"
                                id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>


                        <div class="mb-3">
                            <input placeholder="Konfirmasi Kata Kunci" type="email" class="form-control rounded-3"
                                id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>

                        <div class="flex-sb-m w-full p-t-3 p-b-32">
                            <div style="color: black; font-weight: 600; font-size: 13px">
                                <span>sudah punya akun? klik <a href="" style="font-weight: 600; color: #957DAD; text-decoration: none">masuk</a></span>
                            </div>
                        </div>


                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Daftar
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
