@extends('artis.components.artisTemplate')

@section('content')
    <link rel="stylesheet" href="/user/assets/css/billboard.css">
    @include('partials.tambahkeplaylist')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card thin rounded-4" style="border: 1px solid #EAEAEA;">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-7">
                                    <div class="preview-list">
                                        <div class="d-flex flex-column gap-3" style="color: #6C6C6C;">
                                            <span class="fw-bold fs-4">{{ $billboard->artis->user->name }}</span>
                                            <span class="fs-5">{{ $billboard->deskripsi }}.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 d-flex text-right justify-content-center">
                                    <img src="{{ asset('storage/' . $billboard->image_artis) }}" alt=""
                                        class="d-block" style="width: 250px; height: 350px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="cards d-flex justify-content-center z-3 gap-4"
                        style="margin-top: -150px; margin-left: 12px;">
                        @foreach ($albums as $item)
                            <a href="{{ route('albumBillboard', $item->code) }}">
                                <img src="{{ asset('storage/' . $item->image) }}" width="170"
                                    class="img-fluid rounded-4 fit">
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <h3 class="card-title mb-4 judul" style="font-size: 20px; font-weight: 700">Lagu Populer
                        {{ $billboard->artis->user->name }}</h3>
                    <div class="card scroll scrollbar-down thin">
                        <div class="card-body">
                            <div class="row" style="margin-top: -20px">
                                <div class="col-12">
                                    <div class="preview-list">
                                        @foreach ($songs as $item)
                                            @if ($item->is_approved)
                                                <div class="preview-item">
                                                    <div class="preview-thumbnail">
                                                        <img src="{{ asset('storage/' . $item->image) }}" width="10%">
                                                    </div>
                                                    <div class="preview-item-content d-sm-flex flex-grow">
                                                        <a href="" class="flex-grow text-decoration-none link">
                                                            <h6 class="preview-subject">{{ $item->judul }}</h6>
                                                            <p class="text-muted mb-0">{{ $item->artist->user->name }}</p>
                                                        </a>
                                                    </div>
                                                    <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                        <div class="text-group">
                                                            <i id="like{{ $item->id }}" data-id="{{ $item->id }}"
                                                                onclick="toggleLike(this, {{ $item->id }})"
                                                                class="shared-icon-like {{ $item->isLiked ? 'fas' : 'far' }} fa-heart pr-2"></i>
                                                            <p style="pointer-events: none;">{{ $item->waktu }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endIf
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
    </div>
    </div>
    <script>
        function togglePlayPause() {
            const playIcon = document.getElementById('playIcon');

            if (isPlaying) {
                // Jika sedang diputar, ganti menjadi pause
                playIcon.classList.remove('fa-pause');
                playIcon.classList.add('fa-play');
            } else {
                // Jika sedang tidak diputar, ganti menjadi play
                playIcon.classList.remove('fa-play');
                playIcon.classList.add('fa-pause');
            }

            // Ubah status pemutaran
            isPlaying = !isPlaying;

            // Panggil fungsi justplay() jika diperlukan
            justplay();
        }
    </script>
@endsection
