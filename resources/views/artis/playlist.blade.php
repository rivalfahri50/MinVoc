@extends('artis.components.artisTemplate')


@section('content')
    <div class="main-panel">
        <link rel="stylesheet" href="/user/assets/css/playlist.css">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <h3 class="judul" style="font-size: 20px; font-weight: 600">Rekomendasi Playlist</h3>
                    <div class="cards">
                        @if (!empty($playlists))
                            @foreach ($playlists->reverse() as $item)
                                @if ($item->user_id !== auth()->user()->id)
                                    <a href="{{ route('detailPlaylistArtis', $item->code) }}"
                                        class="card card-scroll coba text-decoration-none">
                                        <div class="card-content">
                                            <div class="kotaktetap">
                                                <img src="{{ asset('storage/' . $item->images) }}"
                                                    class="img-fluid rounded-1 try">
                                            </div>
                                            <h4 class="mt-2 judul">{{ $item->name }}</h4>
                                            <p class="teks overflow-cardtext">
                                                {{ $item->deskripsi === 'none' ? '' : "$item->deskripsi" }}
                                            </p>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <h3 class="judul" style="font-size: 20px; font-weight: 600">Album</h3>
                    <div class="cards">
                        <a href="/artis/disukai-playlist" class="card card-scroll coba text-decoration-none">
                            <div class="card-content">
                                <div class="kotaktetap">
                                    <img src="http://127.0.0.1:8000/storage/images/53e3eyfg734r-r4ry4rgg43ry-34rwerwrww3.png"
                                        class="img-fluid rounded-1">
                                </div>
                                <h5 class="mt-2 judul"> Lagu yang disukai</h5>
                                <p class="teks">lagu-lagu yang kamu tambah ke favorit</p>
                            </div>
                        </a>
                        @if (!empty($albums))
                            @foreach ($albums->reverse() as $item)
                                {{-- @if ($item->artis->user_id == auth()->user()->id) --}}
                                <a href="{{ route('detailAlbumArtis', $item->code) }}"
                                    class="card card-scroll coba text-decoration-none" style="width: 95%">
                                    <div class="card-content">
                                        <div class="kotaktetap">
                                            <img src="{{ asset('storage/' . $item->image) }}"
                                                class="img-fluid rounded-1 try">
                                        </div>
                                        <h5 class="mt-2 judul overflow-cardtext" style="font-weight: bold">
                                            {{ $item->name }}</h5>
                                        <span class="judul" style="font-size: 12px">Dari {{ $item->artis->user->name }}
                                            @if ($item->artis->is_verified)
                                                <span class="mdi mdi-check-decagram text-primary verified-text"></span>
                                            @endif
                                        </span>
                                    </div>
                                </a>
                                {{-- @endif --}}
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection
