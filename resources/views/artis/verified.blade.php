@extends('artis.components.artisTemplate')

@section('content')
    <link rel="stylesheet" href="/user/assets/css/verified.css">

    <!-- partial | ISI -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="judul mb-3 fw-bolder">Daftar Di Sini Untuk Verifikasi Akun Anda</h2>
                            <p class="teks-biasa">Pengajuan verifikasi akun di sini guna untuk meningkatkan
                                kepercayaan dan kredibilitas, perlindungan dari pemalsuan, dukungan dan
                                pelayanan lebih baik, peningkatan visibilitas, pembeda dari akun palsu,
                                meningkatkan profesionalisme, partisipasi dalam fitur khusus dan perlindungan
                                merek. Pengguna harus memenuhi syarat pengajuan verifikasi akun dengan <span
                                    class="highlight">minimal
                                    memiliki jumlah like lagu sebanyak 1.000 like dan sudah bergabung dengan
                                    <span class="judul">MusiCave</span> minimal selama 1 tahun.</span></p>
                            <form class="row" action="{{ route('verified', auth()->user()->code) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="text" class="form-control rounded-4" name="name" id="name"
                                            value="{{ auth()->user()->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-6 mb-4" style="padding-left: 0;">
                                        <h4 class="judul fw-bolder">Masukkan tanda pengenal</h4>
                                        <input type="file" id="foto" name="foto" class="form-control filecolor"
                                            aria-label="Pilih tanda pengenal" required>
                                        @error('foto')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-7">
                                    <button type="submit" class="btn gayabtn mr-3">Kirim</button>
                                    <a href="/" class="btn gayabtn back" type="submit">Kembali</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endSection
