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
                            <input name="email" placeholder="Nama pengguna" type="text" class="form-control rounded-3"
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

    {{-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column gap-4" style="height: 500px; overflow-y: scroll;">
                    <div>
                        <span class="fw-bold">Privacy Policy untuk Hummasoft Technology</span>
                        <p>Di Magang Hummasoft, dapat diakses dari MagangHummasoft.com, salah satu prioritas utama kami
                            adalah
                            privasi pengunjung kami. Dokumen Kebijakan Privasi ini berisi jenis informasi yang dikumpulkan
                            dan
                            dicatat oleh MagangHummasoft.com dan bagaimana kami menggunakannya.</p>
                        <p>
                            Jika Anda memiliki pertanyaan tambahan atau memerlukan informasi lebih lanjut tentang Kebijakan
                            Privasi
                            kami, jangan ragu untuk menghubungi kami.
                        </p>
                    </div>
                    <div>
                        <span class="fw-bold">
                            Informasi yang Kami Kumpulkan
                        </span>
                        <p>
                            MagangHummasoft.com mengikuti prosedur standar menggunakan file log. File-file ini mencatat
                            pengunjung
                            ketika mereka mengunjungi situs web. Semua perusahaan hosting melakukan ini dan merupakanbagian
                            dari
                            analisis layanan hosting. Informasi yang dikumpulkan oleh file log termasuk alamat protokol
                            internet
                            (IP), jenis browser, Penyedia Layanan Internet (ISP), tanggal dan waktu, halaman rujukan/keluar,
                            dan
                            mungkin jumlah klik.Ini tidak terkait dengan informasi apa pun yang dapat diidentifikasi secara
                            pribadi.
                            Tujuan informasi adalah untuk menganalisis jurnal sisiwa magang, mengelola siswa magang, dan
                            pendataran
                            siswa magang.
                        </p>
                    </div>
                    <div>
                        <span class="fw-bold">
                            Cookies
                        </span>
                        <p>
                            Seperti situs web lainnya, MagangHummasoft.com menggunakan ‘cookie’. Cookie digunakan untuk
                            menyimpan
                            informasi seperti preferensi pengunjung dan halaman yang diakses atau dikunjungi pengunjung pada
                            situs
                            web ini. Informasi tersebut kami gunakan untuk mengoptimalkan pengalaman pengguna dengan
                            menyesuaikan
                            konten halaman web kami.
                        </p>
                    </div>
                    <div>
                        <span class="fw-bold">
                            Kebijakan Privasi Pihak Ketiga
                        </span>
                        <p>
                            Kebijakan Privasi MagangHummasoft.com tidak berlaku untuk pengiklan atau situs web lain. Karena
                            itu,
                            kami menyarankan Anda untuk membaca seksama masing-masing Kebijakan Privasi dari pihak ketiga
                            untuk
                            informasi yang lebih rinci. Anda berhak untuk menonaktifkan cookies pada browser Anda.
                        </p>
                    </div>
                    <div>
                        <span class="fw-bold">
                            Persetujuan
                        </span>
                        <p>
                            Dengan menggunakan situs web kami, Anda dengan ini menyetujui Kebijakan Privasi kami dan
                            menyetujui
                            syarat dan ketentuannya.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
