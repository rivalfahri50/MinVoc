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
                                        <h4 class="judul mt-4 clamp-text" style="font-size: 16px">{{ $song->judul }}</h4>
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
                                        @foreach ($songs->reverse() as $item)
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
                                                            <i id="like{{ $item->id }}"
                                                                data-id="{{ $item->id }}"
                                                                onclick="toggleLike(this, {{ $item->id }})"
                                                                class="shared-icon-like {{ $item->isLiked ? 'fas' : 'far' }} fa-heart pr-2"></i>
                                                            </i>
                                                            <p>{{ $item->waktu }}</p>
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


                </script>
            </div>
            <!-- page-body-wrapper ends -->
        </div>
    </div>
@endSection
