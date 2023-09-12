@extends('artis.components.artisTemplate')

@section('content')
    <link rel="stylesheet" href="/user/assets/css/songSearch.css">

    @include('partials.tambahkeplaylist')

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="row">
                        <div class="col-4">
                            <div class="card coba" style="display: flex; width: 400px; height: 200px;">
                                <div class="card-body" style="display: flex;">
                                    <div class="image-container">
                                        <img src="{{ asset('storage/' . $song->image) }}" alt="Face" class="avatar">
                                    </div>
                                    <div style="margin-left: 10px;">
                                        <h4 class="judul mt-4 clamp-text">{{ $song->judul }}</h4>
                                        <div class="d-flex flex-row align-content-center">
                                            <p class="text-muted m-1 clamp-text">{{ $song->artist->user->name }}</p>
                                        </div>
                                        <a href="#lagu-diputar" class="flex-grow text-decoration-none link"
                                            onclick="putar({{ $song->id }})">
                                            <button onclick="togglePlayPause()" id="play" style="border: none">
                                                <i id="playIcon" class="far fa-play-circle ukuraniconplaykhusus"
                                                    style="color: #957DAD;"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <script>
                                        var isPlaying = false; // Default status pemutaran lagu
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr class="divider"> <!-- Divider -->
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <h3 class="card-title judul">Lagu-lagu</h3>
                    <div class="card scroll scrollbar-down thin">
                        <div class="card-body">
                            <div class="row" style="margin-top: -20px">
                                <div class="col-12">
                                    <div class="preview-list">
                                        @foreach ($songs as $item)
                                            <div class="preview-item">
                                                <div class="preview-thumbnail">
                                                    <img src="{{ asset('storage/' . $item->image) }}" width="10%">
                                                </div>
                                                <div class="preview-item-content d-sm-flex flex-grow">
                                                    <a href="#lagu-diputar" class="flex-grow text-decoration-none link"
                                                        onclick="putar({{ $item->id }})">
                                                        <h6 class="preview-subject">{{ $item->judul }}</h6>
                                                        <p class="text-muted mb-0">{{ $item->artist->user->name }}</p>
                                                    </a>
                                                    <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                        <div class="text-group">
                                                            <i onclick="myFunction(this)" class="far fa-heart pr-2">
                                                            </i>
                                                            <p>{{ $item->waktu }}</p>
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#staticBackdrop-{{ $item->code }}"
                                                                style="color: #957dad">
                                                                <svg xmlns="http://www.w3.org/2000/svg" x="0px"
                                                                    y="0px" width="20" height="20"
                                                                    viewBox="0 2 24 24">
                                                                    <path fill="#957DAD"
                                                                        d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 11 7 L 11 11 L 7 11 L 7 13 L 11 13 L 11 17 L 13 17 L 13 13 L 17 13 L 17 11 L 13 11 L 13 7 L 11 7 z">
                                                                    </path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function togglePlayPause() {
                        const playIcon = document.getElementById('playIcon');

                        if (isPlaying) {
                            // Jika sedang diputar, ganti menjadi pause
                            playIcon.classList.remove('fa-pause-circle');
                            playIcon.classList.add('fa-play-circle');
                        } else {
                            // Jika sedang tidak diputar, ganti menjadi play
                            playIcon.classList.remove('fa-play-circle');
                            playIcon.classList.add('fa-pause-circle');
                        }

                        // Ubah status pemutaran
                        isPlaying = !isPlaying;

                        // Panggil fungsi justplay() jika diperlukan
                        justplay();
                    }


                    function myFunction(x) {
                        x.classList.toggle("far"); // Menghapus kelas "fa fa-heart"
                        x.classList.toggle("fas"); // Menambahkan kelas "fas fa-heart"
                        x.classList.toggle("warna-kostum-like"); // Menambahkan kelas warna merah
                    }
                </script>
            </div>
            <!-- page-body-wrapper ends -->
        </div>
    </div>
@endSection
