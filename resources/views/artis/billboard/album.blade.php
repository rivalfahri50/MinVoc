@extends('artis.components.artisTemplate')

@section('content')
    <link rel="stylesheet" href="/user/assets/css/album.css">
    @include('partials.tambahkeplaylist')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="custom-container">
                        <div class="row">
                            <div class="col-3">
                                <div class="card coba">
                                    <img src="{{ asset('storage/' . $album->image) }}" alt="Gambar">
                                </div>
                            </div>
                            <div class="col-3 text-xxl-end">
                                <div class="bottom-left-text d-flex flex-column gap-2">
                                    <p class="m-0" style="font-size: 20px; font-weight: 600">Album {{ $album->name }}
                                    </p>
                                    <div class="img-and-text">
                                        <img class="img-ss rounded-circle"
                                            src="{{ asset('storage/' . $album->artis->user->avatar) }}" alt="">
                                        <p class="judulnottebal" style="font-size: 20px; font-weight: 500">
                                            {{ $album->artis->user->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr class="divider">
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <h3 class="card-title mb-4 judul" style="font-size: 20px; font-weight: 500">Temukan berbagai macam lagu
                        {{ $album->artis->user->name }}</h3>
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
                                                        <a href="#lagu-diputar"
                                                                class="flex-grow text-decoration-none link"
                                                                onclick="putar({{ $item->id }})">
                                                                <h6 class="preview-subject">{{ $item->judul }}</h6>
                                                                <p class="text-muted mb-0">{{ $item->artist->user->name }}
                                                                </p>
                                                            </a>
                                                        <i id="like-2{{ $item->id }}"
                                                            data-id="{{ $item->id }}"
                                                            onclick="toggleLike(this, {{ $item->id }})"
                                                            class="shared-icon-like {{ $item->isLiked ? 'fas' : 'far' }} fa-heart pr-2"></i>
                                                        <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                            <div class="text-group">
                                                                <p>{{ $item->waktu }}</p>
                                                            </div>
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
@endsection
