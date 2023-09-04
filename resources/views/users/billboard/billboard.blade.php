@extends('users.components.usersTemplates')

@section('content')
    <link rel="stylesheet" href="/user/assets/css/billboard.css">
    <div class="main-panel">
        <style>
            .img-fluid {
                object-fit: cover;
                width: 170px;
                height: 100%;
            }
        </style>
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card thin rounded-4" style="border: 1px solid #EAEAEA; background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT6aFi3VmyCOQl4s4lebrRk24Tpz_8V8snunQ&usqp=CAU'); background-size: cover;">
                      <div class="card-body" style="background-color: rgba(255, 255, 255, 0.3);"> <!-- Ganti opacity di sini -->
                        <div class="row">
                          <div class="col-12">
                            <div class="preview-list">
                              <div class="d-flex flex-column gap-3" style="color: #6C6C6C;">
                                <span class="fw-bold fs-4">Agnez Monica</span>
                                <span class="fs-5">Agnes Monica Muljoto, yang dikenal dengan nama profesional Agnez Mo, adalah
                                  seorang penyanyi, penulis lagu, penari, dan aktris Indonesia. Pada awal kariernya, dia juga
                                  dikenal sebagai Agnes Monica.</span>
                                <div class="d-flex gap-4 align-content-center">
                                  <span>
                                    <button style="background-color: #957DAD; border: 1px solid #957dad; padding: 4px 25px;"
                                      class="rounded-3">
                                      <span class="text-white">
                                        Mainkan
                                      </span>
                                    </button>
                                    <span style="margin-left: -20px;">
                                      <svg width="50" height="50" viewBox="0 0 50 50" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="25" cy="25" r="25" fill="white" />
                                        <path
                                          d="M35.2542 21.712C37.5502 23.3028 37.5502 26.6972 35.2542 28.288L23.778 36.2389C21.1252 38.0769 17.5 36.1782 17.5 32.951L17.5 17.049C17.5 13.8217 21.1252 11.9231 23.778 13.7611L35.2542 21.712Z"
                                          fill="#957DAD" />
                                      </svg>
                                    </span>
                                  </span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="cards d-flex justify-content-center z-3 gap-4"
                        style="margin-top: -150px; margin-left: 12px;">
                        <a href="album.html">
                            <img src="/user/assets/images/faces/face8.jpg" width="170" class="img-fluid rounded-4">
                        </a>
                        <a href="#">
                            <img src="/user/assets/images/faces/face1.jpg" width="170" class="img-fluid rounded-4">
                        </a>
                        <a href="#">
                            <img src="/user/assets/images/faces/face1.jpg" width="170" class="img-fluid rounded-4">
                        </a>
                        <a href="#">
                            <img src="/user/assets/images/faces/face1.jpg" width="170" class="img-fluid rounded-4">
                        </a>
                        <a href="#">
                            <img src="/user/assets/images/faces/face1.jpg" width="170" class="img-fluid rounded-4">
                        </a>
                    </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <h3 class="card-title mb-4 judul" style="font-size: 20px; font-weight: 700">Lagu Populer Agnez mo</h3>
                    <div class="card scroll scrollbar-down thin">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="preview-list">
                                        <div class="preview-item">
                                            <div class="preview-thumbnail">
                                                <img src="/user/assets/images/faces/face1.jpg" width="10%">
                                            </div>
                                            <div class="preview-item-content d-sm-flex flex-grow">
                                                <a href="" class="flex-grow text-decoration-none link">
                                                    <h6 class="preview-subject">Tak Ingin Usai</h6>
                                                    <p class="text-muted mb-0">Keisya</p>
                                                </a>
                                            </div>
                                            <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                <div class="text-group">
                                                    <i onclick="myFunction(this)" class="far fa-heart pr-2"></i>
                                                    <p style="pointer-events: none;">2.26</p>
                                                    <a href="#tambahkeplaylist" style="color: #957dad">
                                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 2 24 24">
                                                          <path fill="#957DAD" d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 11 7 L 11 11 L 7 11 L 7 13 L 11 13 L 11 17 L 13 17 L 13 13 L 17 13 L 17 11 L 13 11 L 13 7 L 11 7 z"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tambahkeplaylist">
        <div class="card window">
            <div class="card-body">
                <h3 class="judul p-0 mb-4">Tambah Ke Playlist</h3>
                <a href="#" class="close-button far fa-times-circle"></a>
                <form class="row" action="">
                    <div class="col-md-12">
                        <div class="mb-4">
                            <label for="namaartis" class="form-label judulnottebal">Nama Playlist</label>
                            <select class="form-select" id="namaartis">
                                <option></option>
                                <option>Tulus</option>
                                <option>Afgan</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-md-right">
                        <a href="#" class="btn" type="submit">Tambah</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function myFunction(x) {
            x.classList.toggle("far"); // Menghapus kelas "fa fa-heart"
            x.classList.toggle("fas"); // Menambahkan kelas "fas fa-heart"
            x.classList.toggle("warna-kostum-like"); // Menambahkan kelas warna merah
        }
    </script>
@endsection
