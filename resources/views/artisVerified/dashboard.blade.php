@extends('artisVerified.components.artisVerifiedTemplate')

@section('content')
    <link rel="stylesheet" href="/user/assets/css/dashboard.css">
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
    <div class="main-panel">
        <div class="content-wrapper">
            <style>
                .judul {
                    padding: 5px;
                    color: #957DAD;
                    font-weight: 600;
                    font-size: 20px;
                }

                .jarak {
                    gap: 10px;
                }

                .pcard {
                    padding: 15px 10px;
                }

                .link {
                    color: #85BAD9;
                    border: none;
                    background: none;
                    text-align: left;
                }

                .angka {
                    color: #A86C93;
                    font-weight: 500;
                    display: inline-block;
                }
            </style>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <h3 class="card-title mt-2 judul" style="font-size: 20px; font-weight: 600">Penghasilan</h3>
                    <div class="row">
                        <div style="width: 30%">
                            <div class="card pcard jarak" style="height: 100%;">
                                <h3 class="angka m-0">Rp {{ number_format($totalpenghasilan, 2,',','.')}}   </h3>
                                <h4 class="judulnottebal mb-0">Total penghasilan</h4>
                            </div>
                        </div>
                        <div class="modal fade" id="caripenghasilan" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0" style="background-color: white">
                                    <div class="modal-header border-0">
                                        <h1 class="modal-title fs-5 judul" id="staticBackdropLabel">Detail</h1>
                                        <button type="button" class="btn-unstyled link" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <i class="mdi mdi-close-circle-outline btn-icon"
                                                style="color: #957DAD; font-size: 20px;"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body border-0">
                                        <div class="col-md-12" style="font-size: 13px">
                                            <div class="mb-3">
                                                <p for="namakategori" class="form-label judulnottebal">Total Penghasilan</p>
                                                <h3 class="judul">Rp20.000.000</h3>
                                            </div>
                                            <div class="mb-3">
                                                <p for="konsep" class="form-label judulnottebal">Jumlah Pencairan</p>
                                                <input type="text" id="harga" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn rounded-3">
                                            <a href="" class="btn-link"
                                                style="color: inherit; text-decoration: none;">Setujui</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="width: 70%;">
                            <div class="card pcard" style=" padding: 10px">
                                <h5 class="angka fs-6">Hi, {{ auth()->user()->name }} !</h5>
                                <p class="judulnottebal">Selamat kembali, Artis Ter-Verifikasi! Nikmati pengalaman istimewa
                                    di MusiCave. Jelajahi berbagai fitur dan informasi yang telah kami persiapkan untuk
                                    membantu Anda berkembang dalam karier musik Anda. Kami siap mendukung kesuksesan karier
                                    musik Anda. Terus berkreasi dan berbagi musik terbaik Anda dengan dunia!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <h3 class="card-title mt-2 judul" style="font-size: 20px; font-weight: 600">Kategori</h3>
                    <div class="cards">
                        @foreach ($genres as $item)
                            <a href="/artis-verified/kategori/{{ $item->code }}" class="card cardi card-scroll rounded-4">
                                <img src="{{ asset('storage/' . $item->images) }}" class="img-fluid rounded-4 fit">
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
                                        <a href="{{ route('detail.billboard.artisVerified', $item->code) }}"
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
                    <h3 class="card-title mt-2 judul" style="font-size: 20px; font-weight: 600">Lagu Yang Disarankan</h3>
                    <div class="card datakanan scrollbar-down thin">
                        <div class="card-body">
                            <div class="row" style="margin-top: -20px">
                                <div class="col-12">
                                    <div class="preview-list">
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($songs->reverse() as $item)
                                            @if ($item->is_approved)
                                                <div class="preview-item">
                                                    <div class="preview-thumbnail">
                                                        <img src="{{ asset('storage/' . $item->image) }}" width="10%">
                                                    </div>
                                                    <div class="preview-item-content d-sm-flex flex-grow">
                                                        <a href="#lagu-diputar"
                                                            class="flex-grow text-decoration-none link"
                                                            onclick="putar({{ $item->id }})">
                                                            <h6 class="preview-subject" style="color: #4e4e4e;">
                                                                {{ $item->judul }}</h6>
                                                            <p class="text-muted mb-0" style="font-weight: 400">
                                                                {{ $item->artist->user->name }}</p>
                                                        </a>
                                                    </div>
                                                    <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                        <div class="text-group align-items-center">
                                                            <i id="like{{ $item->id }}"
                                                                data-id="{{ $item->id }}"
                                                                onclick="toggleLike(this, {{ $item->id }})"
                                                                class="shared-icon-like {{ $item->isLiked ? 'fas' : 'far' }} fa-heart pr-2"></i>
                                                            <p style="pointer-events: none;">{{ $item->waktu }}</p>
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
                <div class="col-md-5 grid-margin stretch-card billboardheight">
                    <h3 class="card-title mb-4 judul" style="font-size: 20px; font-weight: 700">Artis yang disukai</h3>
                    <div class="card datakiri scrollbar-down square thin">
                        <div class="card-body">
                            <div class="row" style="margin-top: -20px">
                                <div class="col-12">
                                    <div class="preview-list">
                                        @foreach ($artist->reverse() as $item)
                                            @if ($item->likes >= 0)
                                                <div class="preview-item">
                                                    <div class="preview-thumbnail">
                                                        <img src="{{ asset('storage/' . $item->user->avatar) }}"
                                                            width="10%">
                                                    </div>
                                                    <div class="preview-item-content d-sm-flex flex-grow">
                                                        <div class="flex-grow">
                                                            <h6 class="preview-subject">{{ $item->user->name }}</h6>
                                                            <p class="text-muted mb-0" style="font-weight: 400">
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
                            <span class="table-cell ml-4 "> judul </span>
                            <span class="table-cell " style=" margin-left:430px"> putar </span>
                            <span class="table-cell " style=" margin-left:380px">
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
                                            <div class="preview-item">
                                                <div class="preview-thumbnail">
                                                    <img src="{{ asset('storage/' . $item->image) }}" width="10%">
                                                </div>
                                                <div class="preview-item-content d-sm-flex flex-grow">
                                                    <a href="#lagu-diputar"
                                                        class="flex-grow text-decoration-none link"
                                                        onclick="putar({{ $item->id }})">
                                                        <h6 class="preview-subject" style="color: #4e4e4e;">
                                                            {{ $item->judul }}</h6>
                                                        <p class="text-muted mb-0" style="font-weight: 400">
                                                            {{ $item->artist->user->name }}</p>
                                                    </a>
                                                </div>
                                                <div style="padding-right:400px">
                                                    <p>
                                                        {{ number_format($item->didengar, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                    <div class="text-group align-items-center">
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
@endsection
