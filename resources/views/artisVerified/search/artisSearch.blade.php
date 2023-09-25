@extends('artisVerified.components.artisVerifiedTemplate')

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
                                            @if ($item->is_approved)
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
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
@endSection
