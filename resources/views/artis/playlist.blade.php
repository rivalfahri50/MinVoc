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
                            @foreach ($playlists as $item)
                                @if ($item->user_id !== auth()->user()->id)
                                    <a href="{{ route('detailPlaylistArtis', $item->code) }}"
                                        class="card card-scroll coba text-decoration-none">
                                        <div class="card-content">
                                            <div class="kotaktetap">
                                                <img src="{{ asset('storage/' . $item->images) }}"
                                                    class="img-fluid rounded-1 try">
                                            </div>
                                            <h4 class="mt-2 judul">{{ $item->name }}</h4>
                                            <p class="teks">{{ $item->deskripsi === 'none' ? '' : "$item->deskripsi" }}
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
                        @if (!empty($albums))
                            @foreach ($albums as $item)
                                {{-- @if ($item->artis->user_id == auth()->user()->id) --}}
                                    <a href="{{ route('detailAlbumArtis', $item->code) }}"
                                        class="card card-scroll coba text-decoration-none">
                                        <div class="card-content">
                                            <div class="kotaktetap">
                                                <img src="{{ asset('storage/' . $item->image) }}"
                                                    class="img-fluid rounded-1 try">
                                            </div>
                                            <h4 class="mt-2 judul">{{ $item->name }}</h4>
                                            </p>
                                        </div>
                                    </a>
                                {{-- @endif --}}
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <h3 class="judul" style="font-size: 20px; font-weight: 600">Playlist saya</h3>
                    <div class="cards">
                        @if (!empty($playlists))
                            @foreach ($playlists as $item)
                                @if ($item->user_id == auth()->user()->id)
                                    <a href="{{ route('detailPlaylistArtis', $item->code) }}"
                                        class="card card-scroll coba text-decoration-none">
                                        <div class="card-content">
                                            <div class="kotaktetap">
                                                <img src="{{ asset('storage/' . $item->images) }}"
                                                    class="img-fluid rounded-1 try">
                                            </div>
                                            <h4 class="mt-2 judul">{{ $item->name }}</h4>
                                            <p class="teks">{{ $item->deskripsi === 'none' ? '' : "$item->deskripsi" }}
                                            </p>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
