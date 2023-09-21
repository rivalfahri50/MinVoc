@extends('artis.components.artisTemplate')

@section('content')
    <link rel="stylesheet" href="/user/assets/css/verified.css">

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body" style="{{ $artis->verification_status === "none" ? "height: 65vh;" : "height: 50vh;" }}">
                            <h2 class="judul mb-3 fw-bolder fs-4">Daftar Di Sini Untuk Verifikasi Akun Anda</h2>
                            <p class="teks-biasa">Pengajuan verifikasi akun di sini guna untuk meningkatkan
                                kepercayaan dan kredibilitas, perlindungan dari pemalsuan, dukungan dan
                                pelayanan lebih baik, peningkatan visibilitas, pembeda dari akun palsu,
                                meningkatkan profesionalisme, partisipasi dalam fitur khusus dan perlindungan
                                merek. Pengguna harus memenuhi syarat pengajuan verifikasi akun dengan <span
                                    class="highlight"> minimal memiliki jumlah like lagu sebanyak 1.000 like dan sudah didengar sebanyak 1.500 pengguna.</span></p>
                            <form class="row" action="{{ route('verified', auth()->user()->code) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="text" class="form-control rounded-4" name="name" id="name"
                                            value="{{ auth()->user()->name }}"
                                            style="border: 1px solid #957DAD; color: #6c6c6c;" readonly>
                                    </div>
                                </div>
                                @if ($artis->verification_status === "none")
                                <div class="col-md-12">
                                    <div class="col-6 mb-4" style="padding-left: 0;">
                                        <h4 class="judul fw-bold">Unggah Foto KTP</h4>
                                        <input type="file" id="foto" name="foto" class="form-control filecolor"
                                            aria-label="Pilih tanda pengenal" accept="image/*" required>
                                        @error('foto')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-7">
                                    <button type="submit" class="btn gayabtn mr-3">Kirim</button>
                                </div>
                                @else
                                <div class="fs-6" style="color: #f23f35; font-weight: lighter">Pengajuan telah terkirim, tunggu beberapa saat !</div>
                                @endif
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
