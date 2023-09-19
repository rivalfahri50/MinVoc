@extends('artis.components.artisTemplate')

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
                            <div class="col-9 text-xxl-end">
                                <div class="bottom-left-text">
                                    <h3 class="judul">{{ $user->name }}</h3>
                                    <p class="m-0" style="color: #957dad; font-weight: 400;">662,429 didengar
                                        <span class="fas fa-circle mr-2 ml-2"
                                            style="color: #cccccc; font-size: 8px;"></span> 145,534 disukai
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
                    <a href="#lagu-diputar" class="flex-grow text-decoration-none link"
                    onclick="putar({{ 'id' }})">
                    <button onclick="togglePlayPause()" id="play" style="border: none; background:none">
                        <i id="playIcon" class="far fa-play-circle ukuraniconplay" style="color: #957DAD;"></i>
                    </button>
                </a>
                <script>
                    var isPlaying = false; // Default status pemutaran lagu
                </script>
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
                                                            <i id="like{{$item->id}}" data-id="{{ $item->id }}"
                                                                onclick="toggleLike(this, {{ $item->id }})"
                                                                class="shared-icon-like {{ $item->isLiked ? 'fas' : 'far' }} fa-heart pr-2"></i>
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
