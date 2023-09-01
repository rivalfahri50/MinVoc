@extends('users.components.usersTemplates')

@section('content')
    <link rel="stylesheet" href="/user/assets/css/contohPlaylist.css">
    <link rel="stylesheet" href="/user/assets/css/buatPlaylist.css">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="custom-container">
                        <div class="row">
                            <div class="col-3">
                                @if ($playlistDetail->user_id === auth()->user()->id)
                                    <div class="col-3">
                                        <a href="#popup" class="card coba">
                                            <img src="{{ asset('storage/' . $playlistDetail->images) }}" alt="Gambar">
                                        </a>
                                    </div>
                                @else
                                    <div class="col-3">
                                        <div class="card coba">
                                            <img src="{{ asset('storage/' . $playlistDetail->images) }}" alt="Gambar">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            {{-- @if ($playlistDetail->user_id === auth()->user()->id)
                                <div class="col-3">
                                    <a href="#popup" class="card coba">
                                        <img src="{{ asset('storage/' . $playlistDetail->images) }}" alt="Gambar" width="100">
                                    </a>
                                </div>
                            @else
                                <div class="col-3">
                                    <img src="{{ asset('storage/' . $playlistDetail->images) }}" alt="Gambar" width="100">
                                </div>
                            @endif --}}
                            <div class="col-3 text-xxl-end">
                                <div class="bottom-left-text">
                                    <h3 class="m-0" style="font-weight: 600">{{ $playlistDetail->name }}
                                    </h3>
                                    <p style="font-size: 18px;">
                                        {{ $playlistDetail->deskripsi == 'none' ? '' : "$playlistDetail->deskripsi" }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-3 text-xxl-end">
                            <div class="bottom-left-text">
                                <p class="m-0" style="font-size: 18px; font-weight: 500">{{ $playlistDetail->name }}
                                </p>
                                <h3 style="font-size: 18px; font-weight: 600">
                                    {{ $playlistDetail->deskripsi == 'none' ? '' : "$playlistDetail->deskripsi" }}
                                </h3>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <hr class="divider"> <!-- Divider -->
            </div>
            <div class="col-md-12 grid-margin stretch-card">
                <h3 class="card-title judul">Temukan berbagai lagu</h3>
                <form class="col-6 mb-4 p-0 nav-link search">
                    <input type="text" class="form-control rounded-4" placeholder="Cari musik">
                </form>
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
                                                <div class="flex-grow">
                                                    <h6 class="preview-subject">{{ $item->judul }}</h6>
                                                    <p class="text-muted mb-0">{{ $item->artist->user->name }}</p>
                                                </div>
                                                <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                    <div class="text-group">
                                                        <i onclick="myFunction(this)" class="far fa-heart pr-2">
                                                        </i>
                                                        <p>{{ $item->waktu }}</p>
                                                        <i class="fas fa-ellipsis-v"></i>
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
    </div>
    </div>

    <style>
        .btn-delete {
            background-color: rgb(215, 0, 0);
        }

        .btn-delete:hover {
            color: red;
            background-color: white;
            border: 1px solid red;
        }
        
        .button-container {
            display: inline-block;
        }
    </style>

    <div id="popup">
        <div class="card window">
            <div class="card-body">
                <a href="#" class="close-button mdi mdi-close-circle-outline"></a>
                <h3 class="judul">Edit Playlist</h3>
                <div>
                    <form class="row" action="{{ route('ubah.playlist', $playlistDetail->code) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-4">
                            <div class="card cobai">
                                <label for="gambar" id="tampil_gambar">
                                    <img src="{{ asset('storage/' . $playlistDetail->images) }}"
                                        style="background-size: cover; background-repeat: no-repeat" width="150"
                                        alt="Gambar">
                                </label>
                                <input type="file" id="gambar" name="images" accept="image/png,image/jpg">
                            </div>
                        </div>
                        <div class="col-md-7 ml-4">
                            <div class="mb-3">
                                <input type="text" class="form-control form-i" name="name" id="nama"
                                    placeholder="{{ $playlistDetail->name }}">
                            </div>
                            <div class="mb-3">
                                <textarea id="deskripsi" class="form-control" name="deskripsi" maxlength="500" rows="6" placeholder="{{ $playlistDetail->deskripsi == 'none' ? '' : $playlistDetail->deskripsi }}"></textarea>
                            </div>
                        </div>
                        <div class="text-md-right col-md-12">
                            <div class="button-container"> <!-- Add this container -->
                                <button class="btn btn-primary" type="submit">Ubah</button>
                                <button form="hapus" class="btn btn-delete" type="submit">Hapus</button>
                            </div>
                        </div>
                    </form>
                    <form id="hapus" action="{{ route('hapus.playlist.user', $playlistDetail->code) }}" method="GET">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function myFunction(x) {
            x.classList.toggle("far"); // Menghapus kelas "fa fa-heart"
            x.classList.toggle("fas"); // Menambahkan kelas "fas fa-heart"
            x.classList.toggle("warna-kostum-like"); // Menambahkan kelas warna merah
        }

        const gambar = document.querySelector("#gambar");

        const tampilGambar = document.querySelector("#tampil_gambar");

        gambar.addEventListener("change", function() {
            const reader = new FileReader();

            reader.addEventListener("load", () => {
                tampilGambar.style.backgroundImage = `url(${reader.result})`;

                tampilGambar.innerHTML = "";
            });

            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
