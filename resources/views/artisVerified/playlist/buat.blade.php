@extends('artisVerified.components.artisVerifiedTemplate')

@section('content')
    <link rel="stylesheet" href="/user/assets/css/buatPlaylist.css">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="custom-container">
                        <div class="row">
                            <div class="col-3">
                                <a href="#popup" class="card coba">
                                    <i class="fas fa-music fa-3x"></i>
                                </a>
                            </div>
                            <div class="col-3 text-xxl-end">
                                <div class="bottom-left-text d-flex flex-column gap-1">
                                    <p class="m-0" style="font-size: 18px; font-weight: 500">Playlist</p>
                                    <a href="#popup">
                                        <h3 style="font-size: 18px; font-weight: 600">Buat Playlist</h3>
                                    </a>
                                    <div class="img-and-text">
                                        <img class="img-ss rounded-circle" src="/user/assets/images/faces/face15.jpg"
                                            alt="">
                                        <p class="judulnottebal fw-bold">Henry Klein</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr class="divider"> <!-- Divider -->
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <h3 class="card-title judul">Mari temukan lagu untuk playlist anda</h3>
                    <form class="col-6 mb-4 p-0 nav-link search">
                        <input type="text" class="form-control rounded-4" placeholder="Cari musik">
                    </form>
                    <div class="card scroll scrollbar-down thin">
                        <div class="card-body">
                            <div class="row" style="margin-top: -20px">
                                <div class="col-12">
                                    <div class="preview-list">
                                        <div class="preview-item">
                                            <div class="preview-thumbnail">
                                                <img src="/user/assets/images/faces/face1.jpg" width="10%">
                                            </div>
                                            <div class="preview-item-content d-sm-flex flex-grow">
                                                <div class="flex-grow">
                                                    <h6 class="preview-subject">Tak Ingin Usai</h6>
                                                    <p class="text-muted mb-0">Keisya</p>
                                                </div>
                                                <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                    <div class="text-group">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-md">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="preview-item">
                                            <div class="preview-thumbnail">
                                                <img src="/user/assets/images/faces/face1.jpg" width="10%">
                                            </div>
                                            <div class="preview-item-content d-sm-flex flex-grow">
                                                <div class="flex-grow">
                                                    <h6 class="preview-subject">Tak Ingin Usai</h6>
                                                    <p class="text-muted mb-0">Keisya</p>
                                                </div>
                                                <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                    <div class="text-group">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-md">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="preview-item">
                                            <div class="preview-thumbnail">
                                                <img src="/user/assets/images/faces/face1.jpg" width="10%">
                                            </div>
                                            <div class="preview-item-content d-sm-flex flex-grow">
                                                <div class="flex-grow">
                                                    <h6 class="preview-subject">Tak Ingin Usai</h6>
                                                    <p class="text-muted mb-0">Keisya</p>
                                                </div>
                                                <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                    <div class="text-group">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-md">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="preview-item">
                                            <div class="preview-thumbnail">
                                                <img src="/user/assets/images/faces/face1.jpg" width="10%">
                                            </div>
                                            <div class="preview-item-content d-sm-flex flex-grow">
                                                <div class="flex-grow">
                                                    <h6 class="preview-subject">Tak Ingin Usai</h6>
                                                    <p class="text-muted mb-0">Keisya</p>
                                                </div>
                                                <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                    <div class="text-group">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-md">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="preview-item">
                                            <div class="preview-thumbnail">
                                                <img src="/user/assets/images/faces/face1.jpg" width="10%">
                                            </div>
                                            <div class="preview-item-content d-sm-flex flex-grow">
                                                <div class="flex-grow">
                                                    <h6 class="preview-subject">Tak Ingin Usai</h6>
                                                    <p class="text-muted mb-0">Keisya</p>
                                                </div>
                                                <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                    <div class="text-group">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-md">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="preview-item">
                                            <div class="preview-thumbnail">
                                                <img src="/user/assets/images/faces/face1.jpg" width="10%">
                                            </div>
                                            <div class="preview-item-content d-sm-flex flex-grow">
                                                <div class="flex-grow">
                                                    <h6 class="preview-subject">Tak Ingin Usai</h6>
                                                    <p class="text-muted mb-0">Keisya</p>
                                                </div>
                                                <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                    <div class="text-group">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-md">Add</button>
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
    </div>

    <div id="popup">
        <div class="card window">
            <div class="card-body">
                <a href="#" class="close-button mdi mdi-close-circle-outline"></a>
                <h3 class="judul">Edit Detail</h2>
                    <form class="row" action="">
                        <div class="col-4">
                            <div class="card cobai">
                                <label for="gambar" id="tampil_gambar">
                                    <i class="fas fa-pen fa-2x"></i>
                                </label>
                                <input type="file" id="gambar" accept="image/png,image/jpg">
                            </div>
                        </div>
                        <div class="col-md-7 ml-4">
                            <div class="mb-3">
                                <input type="text" class="form-control form-i" id="nama"
                                    placeholder="Judul Playlist" required>
                            </div>
                            <div class="mb-3">
                                <textarea id="deskripsi" class="form-control" maxlength="500" rows="6" placeholder="Deskripsi" required></textarea>
                            </div>
                        </div>
                        <div class="text-md-right">
                            <a href="buat.html" class="btn" type="submit">Simpan</a>
                        </div>
                    </form>
            </div>
        </div>
    </div>
    </div>
    </div>



    <script>
        function myFunction(x) {
            x.classList.toggle("far"); // Menghapus kelas "fa fa-heart"
            x.classList.toggle("fas"); // Menambahkan kelas "fas fa-heart"
            x.classList.toggle("warna-kostum-like"); // Menambahkan kelas warna merah
        }

        const gambar = document.querySelector("#gambar");

        const tampilGambar = document.querySelector("#tampil_gambar");

        gambar.addEventListener("change", function() {
            const reader = new FileReader();

            reader.addEventListener("load", () => {
                tampilGambar.style.backgroundImage = `url(${reader.result})`;

                tampilGambar.innerHTML = "";
            });

            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
