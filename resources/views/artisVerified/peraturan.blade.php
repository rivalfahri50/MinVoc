@extends('artisVerified.components.artisVerifiedTemplate')

@section('content')
    <div class="main-panel">
        <style>
            .card .card-body {
                padding: 2rem 2.75rem;
            }

            .judul {
                color: #957DAD;
                font-size: 20px
            }

            .teks-biasa {
                color: #6c6c6c;
            }

            .highlight {
                color: #957DAD;
            }
        </style>
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card coba" style="background-color: #D9D9D9">
                                <img src="/assets/images/logo.svg" width="35%" height="100%" alt="logo"
                                    style="margin: 25px 35%" />
                            </div>

                            <br>

                            <h3 class="judul mb-3 p-0 fw-bolder">Informasi</h3>
                            <p class="teks-biasa">Dalam era distribusi musik digital, pemahaman tentang mekanisme pembagian
                                royalti di antara para pemangku kepentingan adalah kunci untuk memastikan keberlanjutan
                                industri musik. Pembagian royalti di era streaming musik telah menghadirkan tantangan baru,
                                dengan pertanyaan yang muncul tentang bagaimana pencipta lagu dapat memperoleh imbalan yang
                                adil. <span class="highlight"> Berikut adalah peraturan dan informasi mengenai pembagian
                                    royalti pada MusiCave</span>
                            </p>
                            <p class="teks-biasa">1. Setiap satu kali pemutaran lagu mendapatkan <span class="highlight">komisi sebesar Rp 45.000</span>.
                                Penghasilan bersih akan dibagi kepada platform sebesar 10% <br>
                                2. Setiap satu kali mendapat like mendapatkan <span class="highlight">komisi sebesar Rp 20.000</span>. Penghasilan bersih
                                akan dibagi kepada platform sebesar 10%<br>
                                3. Setiap satu kali mengunggah lagu mendapatkan <span class="highlight">komisi sebesar Rp 200.000</span>. Penghasilan
                                bersih akan dibagi kepada admin sebesar 10%<br>
                                4. Keuntungan mendaftar sebagai artis verifikasi adalah mendapatkan akses untuk ditampilkan
                                pada iklan dan akan mendapat <span class="highlight">komisi sebesar Rp 150.000</span>. Penghasilan bersih akan dibagi
                                kepada admin sebesar 20%
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
