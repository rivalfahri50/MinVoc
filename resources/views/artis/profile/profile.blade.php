@extends('artis.components.artisTemplate')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 stretch-card">
                    <h4 style="font-size: 20px; font-weight: 600; color: #957dad">Profil</h4>
                    <p>Atur akun anda, Semua perubahan akan di aplikasikan ke semua halaman</p>
                </div>
                <form class="row" action="">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <h4 style="font-size: 20px; font-weight: 600; color: #957dad">Foto profil</h4>
                            <img src="../assets/images/faces/face15.jpg" class="rounded-circle" width="100px">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label" style="font-size: 20px; font-weight: 600; color: #957dad">Nama pengguna</label>
                            <input type="text" class="form-control" id="nama" value="Henry Klein" readonly disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label" style="font-size: 20px; font-weight: 600; color: #957dad">Email</label>
                            <input type="email" class="form-control" id="email" value="henry123@gmail.com" readonly
                                disabled>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label" style="font-size: 20px; font-weight: 600; color: #957dad">Deskripsi</label>
                            <textarea id="deskripsi" class="form-control" maxlength="500" rows="5" readonly disabled>Halo! Saya Johan, jiwa petualang yang penuh rasa ingin tahu dan selalu dalam pencarian ilmu dan penemuan diri.
Minat: Teknologi, ilmu pengetahuan, dan inovasi Membaca, menulis, dan puisi Alam, mendaki, berkemah, dan fotografi
Filosofi: Terimalah tantangan dan kegagalan untuk pertumbuhan pribadi Ketangguhan dan adaptabilitas adalah kunci
Saya sangat menyukai percakapan bermakna dan kolaborasi! Hubungi saya, dan mari kita berdampak positif bersama.</textarea>
                            <div id="counter" class="float-right"></div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-1">
                        <a href="/artis/profile-ubah" class="btn" type="submit">Perbarui</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="../assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="../assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    </body>
@endsection
