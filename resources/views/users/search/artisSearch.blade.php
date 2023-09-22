@extends('users.components.usersTemplates')

@section('content')
    <link rel="stylesheet" href="/user/assets/css/userSearch.css">

    @include('partials.tambahkeplaylist')

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="custom-container">
                        <div class="row">
                            <div class="col-3">
                                <div class="card coba">
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Gambar">
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="bottom-left-text">
                                    <h3 class="judul">{{ $user->name }}</h3>
                                    <p class="m-0" style="color: #957dad; font-weight: 400;">{{ $totalDidengar }}
                                        didengar
                                        <span class="fas fa-circle mr-2 ml-2"
                                            style="color: #cccccc; font-size: 8px;"></span>
                                        {{ number_format($user->artist->likes, 0, ',', '.') }} disukai
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr class="divider">
                </div>
                <div class="col-md-12 grid-margin stretch-card">
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
                                                            <i id="like-artist{{ $item->id }}"
                                                                data-id="{{ $item->id }}"
                                                                onclick="likeArtist(this, {{ $item->id }})"
                                                                class="like {{ $item->isLiked ? 'fas' : 'far' }} fa-heart pr-2"></i>
                                                            <p>{{ $item->waktu }}</p>
                                                            @if (count($playlists) > 0)
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
                                                            @endif
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
@endSection
