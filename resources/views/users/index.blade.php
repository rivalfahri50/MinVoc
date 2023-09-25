@extends('users.components.usersTemplates')

@section('content')
    @include('partials.tambahkeplaylist')
    <style>
        .header {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            margin-bottom: 10px;
            background-color: #957DAD;
            overflow: hidden;
        }

        .table-cell {
            flex: 1;
            padding-left: 10%;
            text-align: left;
            padding: 10px;
        }

        .table-header {
            color: white;
        }


        .table-cell h6,
        .table-cell p {
            margin: 0;
            padding: 5px 0;
        }

        /*---- style untuk header dengan border lengkung ----*/
        .headerlengkung th:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .headerlengkung th:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }
    </style>

    <link rel="stylesheet" href="/user/assets/css/dashboard.css">

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <h3 class="card-title mt-2 judul" style="font-size: 20px; font-weight: 600">Genre</h3>
                    <div class="cards">
                        @foreach ($genres->reverse() as $item)
                            <a href="/pengguna/kategori/{{ $item->code }}" class="card cardi card-scroll rounded-4">
                                <img src="{{ asset('storage/' . $item->images) }}" class="img-fluid rounded-4 fit"
                                    width="100%" height="100%">
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card border-0 bg-dark coba">
                        <div id="carouselExampleAutoplaying" class="carousel slide carousel-fade" data-bs-ride="carousel"
                            data-interval="2000">
                            <div class="carousel-inner">
                                @foreach ($billboards as $index => $item)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <a href="{{ route('detail.billboard.pengguna', $item->code) }}"
                                            class="image-container">
                                            <img src="{{ asset('storage/' . $item->image_background) }}"
                                                class="d-block billboard" alt="...">
                                            <div class="bottom-left">
                                                <h3 class="text-light">{{ $item->artis->user->name }}</h3>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <h3 class="card-title mt-2 judul" style="font-size: 20px; font-weight: 600">Lagu Terbaru</h3>
                    <div class="card datakanan scrollbar-down thin">
                        <div class="card-body">
                            <div class="row" style="margin-top: -20px">
                                <div class="col-12">
                                    <div class="preview-list">
                                        {{-- @php
                                            $index_no = 0;
                                        @endphp --}}
                                        @foreach ($songs as $item)
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
                                                    </div>
                                                    <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                        <div class="text-group align-items-center">
                                                            <i id="like{{ $item->id }}" data-id="{{ $item->id }}"
                                                                onclick="toggleLike(this, {{ $item->id }})"
                                                                class="shared-icon-like {{ $item->isLiked == '1' ? 'fas' : 'far' }} fa-heart pr-2"></i>
                                                            <p style="pointer-events: none;">{{ $item->waktu }}</p>
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
                                            @endIf
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 stretch-card billboardheight">
                    <h3 class="card-title mb-4 judul" style="font-size: 20px; font-weight: 700">Artis yang disukai</h3>
                    <div class="card datakiri scrollbar-down square thin">
                        <div class="card-body">
                            <div class="row" style="margin-top: -20px">
                                <div class="col-12">
                                    <div class="preview-list">
                                        @foreach ($artist->reverse() as $item)
                                            @if ($item->user_id !== auth()->user()->id)
                                                <div class="preview-item">
                                                    <div class="preview-thumbnail">
                                                        <img src="{{ asset('storage/' . $item->user->avatar) }}" class="fotoartis">
                                                    </div>
                                                    <div class="preview-item-content d-sm-flex flex-grow">
                                                        <div class="preview-item-content d-sm-flex flex-grow align-items-center">
                                                            <div class="flex-grow">
                                                                <h6 class="preview-subject">{{ $item->user->name }}</h6>
                                                                <p class="text-muted mb-0">
                                                                    <span
                                                                        id="likeCount{{ $item->id }}">{{ number_format($item->likes, 0, ',', '.') }}</span>
                                                                    suka
                                                                </p>
                                                            </div>
                                                            <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                                <i id="like-artist{{ $item->id }}"
                                                                    data-id="{{ $item->id }}"
                                                                    onclick="likeArtist(this, {{ $item->id }})"
                                                                    class="like {{ $item->isLiked ? 'fas' : 'far' }} fa-heart pr-2"></i>
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
                <div class="col-12">
                    <h3 class="card-title mt-2 judul" style="font-size: 20px; font-weight: 600">Lagu Yang Sering Didengar
                    </h3>
                    <div class="table-header">
                        <div class="table-row header headerlengkung row ml-0 mr-0 mb-0 ">
                            <span class="table-cell ml-4 "> Judul </span>
                            <span class="table-cell "  style=" margin-left:430px"> Putar </span>
                            <span class="table-cell " style=" margin-left:390px">
                                <i class=" fa fa-clock"></i>
                             </span>
                        </div>
                    </div>
                    <div class="card datakanan scrollbar-down thin">
                        <div class="card-body">
                            <div class="row" style="margin-top: -20px">
                                <div class="col-12">
                                    <div class="preview-list">
                                        @foreach ($song as $item)
                                            @if ($item->is_approved)
                                                {{-- @if (count($songs) > 0) --}}
                                                <div>
                                                </div>
                                                    <div class="preview-item">
                                                        <div class="preview-thumbnail">
                                                            <img src="{{ asset('storage/' . $item->image) }}"
                                                                width="10%">
                                                        </div>
                                                        <div class="preview-item-content d-sm-flex flex-grow">
                                                            <a href="#lagu-diputar"
                                                                class="flex-grow text-decoration-none link"
                                                                onclick="putar({{ $item->id }})">
                                                                <h6 class="preview-subject">{{ $item->judul }}</h6>
                                                                <p class="text-muted mb-0">{{ $item->artist->user->name }}
                                                                </p>
                                                            </a>
                                                        </div>
                                                        <div style="padding-right:400px">
                                                            <p>
                                                                {{ number_format($item->didengar, 0, ',', '.') }}
                                                            </p>
                                                        </div>
                                                        <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                            <div class="text-group align-items-center">
                                                                <i id="like-suka{{ $item->id }}" data-id="{{ $item->id }}"
                                                                    onclick="toggleLike(this, {{ $item->id }})"
                                                                    class="shared-icon-like {{ $item->isLiked ? 'fas' : 'far' }} fa-heart pr-2"></i>
                                                                <p style="pointer-events: none;">{{ $item->waktu }}</p>
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
                                                {{-- @endif --}}
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
@endsection
