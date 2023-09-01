@extends('artisVerified.components.artisVerifiedTemplate')

@section('content')
    <link rel="stylesheet" href="/user/assets/css/kategori.css">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="custom-container">
                        <div class="row">
                            <div class="col-3">
                                <div class="card coba">
                                    <img src="{{ asset('storage/' . $genre->images) }}" alt="Gambar">
                                </div>
                            </div>
                            <div class="col-3 text-xxl-end">
                                <div class="bottom-left-text d-flex flex-column gap-2">
                                    <p class="m-0" style="font-size: 20px; font-weight: 500">Kategori</p>
                                    <h3 style="font-size: 24px; font-weight: 700">Musik {{ $genre->name }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr class="divider"> <!-- Divider -->
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <h3 class="card-title mb-4" style="font-size: 18px; font-weight: 600">Temukan berbagai lagu bergenre
                        {{ $genre->name }}</h3>
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


    <script>
        function myFunction(x) {
            x.classList.toggle("far"); // Menghapus kelas "fa fa-heart"
            x.classList.toggle("fas"); // Menambahkan kelas "fas fa-heart"
            x.classList.toggle("warna-kostum-like"); // Menambahkan kelas warna merah
        }
    </script>
@endsection
