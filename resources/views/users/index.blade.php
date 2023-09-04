@extends('users.components.usersTemplates')

@section('content')
    <link rel="stylesheet" href="/user/assets/css/dashboard.css">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <h3 class="card-title mt-2 judul" style="font-size: 20px; font-weight: 600">Kategori</h3>
                    <div class="cards">
                        @foreach ($genres as $item)
                            <a href="/pengguna/kategori/{{ $item->code }}" class="card card-scroll">
                                <img src="{{ asset('storage/' . $item->images) }}"
                                    class="img-fluid rounded-4 this">
                            </a>
                        @endforeach
                    </div>
                    
                </div>
                <div class="col-md-7">
                    <div class="card border-0 bg-dark coba">
                        <div id="carouselExampleAutoplaying" class="carousel slide carousel-fade" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active" data-bs-interval="2000">
                                    <a href="billboard/billboard.html" class="image-container">
                                        <img src="/user/assets/images/dashboard/img_3.jpg" class="d-block try"
                                            alt="...">
                                        <div class="bottom-left">
                                            <h3 class="text-light">37 tahun Agnez Mo</h3>
                                        </div>
                                    </a>
                                </div>
                                <div class="carousel-item" data-bs-interval="2000">
                                    <a href="" class="image-container">
                                        <img src="/user/assets/images/dashboard/img_2.jpg" class="d-block try"
                                            alt="...">
                                        <div class="bottom-left">
                                            <h3 class="text-light">9 tahun Aal</h3>
                                        </div>
                                    </a>
                                </div>
                                <div class="carousel-item" data-bs-interval="2000">
                                    <a href="#" class="image-container">
                                        <img src="/user/assets/images/dashboard/img_1.jpg" class="d-block try"
                                            alt="...">
                                        <div class="bottom-left">
                                            <h3 class="text-light">99 tahun Agnez Mo</h3>
                                        </div>
                                    </a>
                                </div>
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
                    <h3 class="card-title mt-2 judul" style="font-size: 20px; font-weight: 600">Lagu Yang Disarankan</h3>
                    <div class="card datakanan scrollbar-down thin">
                        <div class="card-body">
                            <div class="row" style="margin-top: -20px">
                                <div class="col-12">
                                    <div class="preview-list">
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($songs as $item)
                                            <div class="preview-item">
                                                <div class="preview-thumbnail">
                                                    <img src="{{ asset('storage/' . $item->image) }}" width="10%">
                                                </div>
                                                <div class="preview-item-content d-sm-flex flex-grow">
                                                    <a href="#lagu-diputar" class="flex-grow text-decoration-none link"
                                                        onclick="putar({{ $i++ }})">
                                                        <h6 class="preview-subject">{{ $item->judul }}</h6>
                                                        <p class="text-muted mb-0">{{ $item->artist->user->name }}</p>
                                                    </a>
                                                </div>
                                                <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                    <div class="text-group align-items-center">
                                                        <i onclick="toggleLike({{ $item->id }},this)" class="far fa-heart pt-1 pr-2"></i>
                                                        <p style="pointer-events: none;">{{ $item->waktu }}</p>
                                                        <a href="#tambahkeplaylist" style="color: #957dad">
                                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 2 24 24">
                                                              <path fill="#957DAD" d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 11 7 L 11 11 L 7 11 L 7 13 L 11 13 L 11 17 L 13 17 L 13 13 L 17 13 L 17 11 L 13 11 L 13 7 L 11 7 z"></path>
                                                            </svg>
                                                          </a>
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
                <div class="col-md-5 grid-margin stretch-card">
                    <h3 class="card-title mb-4 judul" style="font-size: 20px; font-weight: 700">Artis yang disukai</h3>
                    <div class="card datakiri scrollbar-down square thin">
                        <div class="card-body">
                            <div class="row" style="margin-top: -20px">
                                <div class="col-12">
                                    <div class="preview-list">
                                        @foreach ($artist as $item)
                                            @if (!$item->didengar === 0)
                                                <div class="preview-item">
                                                    <div class="preview-thumbnail">
                                                        <img src="/user/assets/images/faces/face1.jpg" width="10%">
                                                    </div>
                                                    <div class="preview-item-content d-sm-flex flex-grow">
                                                        <div class="flex-grow">
                                                            <h6 class="preview-subject">{{ $item->user->name }}</h6>
                                                            <p class="text-muted mb-0">{{ $item->didengar }} didengar</p>
                                                        </div>
                                                        <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                            <i onclick="myFunction(this)" class="far fa-heart pr-2"></i>
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

    <div id="tambahkeplaylist">
        <div class="card window">
            <div class="card-body">
                <h3 class="judul p-0 mb-4">Tambah Ke Playlist</h3>
                <a href="#" class="close-button far fa-times-circle"></a>
                <form class="row" action="">
                    <div class="col-md-12">
                        <div class="mb-4">
                            <label for="namaartis" class="form-label judulnottebal">Nama Playlist</label>
                            <select class="form-select" id="namaartis">
                                <option></option>
                                <option>Tulus</option>
                                <option>Afgan</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-md-right">
                        <a href="#" class="btn" type="submit">Tambah</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
