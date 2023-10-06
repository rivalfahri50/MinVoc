<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.0/howler.min.js"></script>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="/user/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/user/assets/css/style.css">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="shortcut icon" href="/image/favicon.svg" type="image/x-icon">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,400;0,500;1,100;1,200&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .fixedbar {
            position: fixed;
            z-index: 1030;
            width: 245px;
        }

        .search-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            width: 100%;
            max-width: 400px;
            /* Set the maximum width as needed */
        }

        /* Style Untuk search input */
        .search-input {
            border-radius: 15px;
            border: 1px solid #eaeaea;
            padding: 5px 10px;
            width: 100%;
        }

        /* Style Untuk search results */
        #search-results {
            list-style: none;
            position: absolute;
            top: 60px;
            left: 30px;
            width: 52%;
            background-color: white;
            border: 1.5px solid #eaeaea;
            padding: 10px;
            display: none;
            border-radius: 10px;
            font-size: 15px
        }


        .profile-box {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }

        .profile-picture {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-name {
            margin: 0;
            font-weight: bold;
            font-size: 14px;
        }

        #buat-album {
            width: 100%;
            height: 100%;
            position: fixed;
            background: rgba(0, 0, 0, .7);
            top: 0;
            left: 0;
            z-index: 9999;
            visibility: hidden;
        }

        #buat-album .card-body {
            padding: 10px 7% 10px 7%;
        }

        /* Memunculkan Jendela Pop Up*/
        #buat-album:target {
            visibility: visible;
        }

        .window {
            background-color: #ffffff;
            width: 350px;
            border-radius: 10px;
            position: relative;
            margin: 13% auto;
            padding: 10px;
        }

        .close-button {
            display: block;
            color: #957DAD;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .closebutton {
            display: block;
            color: #957DAD;
            position: absolute;
            right: 10px;
        }

        .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .dropdown-menu.navbar-dropdown .dropdown-item:hover {
            color: inherit;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            color: inherit;
            text-decoration: none;
            background-color: inherit;
        }

        .popupalasan:hover {
            color: #957DAD
        }

        .fa-heart:before {
            content: "\f004";
            color: #957DAD;
        }

        /* CSS untuk styling pagination */
        .pagination {
            margin-top: 20px;
        }

        .page-item:first-child .page-link {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-radius: 10px;
        }

        .page-item:last-child .page-link {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-radius: 10px;
        }

        .pagination li {
            display: inline;
            margin-right: 5px;
        }

        .pagination li a {
            text-decoration: none;
            border-radius: 10px;
        }

        .page-link.active {
            background-color: #957DAD;
            border: 1px solid #957DAD;
        }

        .pagination li.active a {
            color: #fff;
        }

        .pagination li:hover {
            background-color: #ddd;
        }
    </style>
    <style>
        /* CSS untuk styling pagination */
        .pagination {
            margin-top: 20px;
        }

        .page-item:first-child .page-link {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-radius: 10px;
        }

        .page-item:last-child .page-link {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-radius: 10px;
        }

        .pagination li {
            display: inline;
            margin-right: 5px;
        }

        .pagination li a {
            text-decoration: none;
        }

        .page-link.active {
            background-color: #957DAD;
            border: 1px solid #957DAD;
        }

        .pagination li.active a {
            color: #fff;
        }

        .pagination li:hover {
            background-color: #ddd;
        }
    </style>
    <script>
        // INI SCRIPT UNTUK HASIL SEARCH TAMPIL/TIDAK
        document.addEventListener("DOMContentLoaded", function() {
            let searchInput = document.getElementById("search");
            let searchResults = document.getElementById("search-results");

            searchInput.addEventListener("input", function() {
                if (searchInput.value.trim() !== "") {
                    searchResults.style.display = "block";
                } else {
                    searchResults.style.display = "none";
                }
            });
        });
    </script>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="/artis/dashboard"><img src="/user/assets/images/logo.svg"
                        alt="logo" /></a>
            </div>
            <ul class="nav fixedbar">
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis/dashboard">
                        <span class="menu-icon ">
                            <i class="mdi mdi-home"></i>
                        </span>
                        <span class="menu-title">Beranda</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis/playlist">
                        <span class="menu-icon">
                            <i class="mdi mdi-music"></i>
                        </span>
                        <span class="menu-title">Album</span>
                        <a href="#ui-basic" data-toggle="collapse" aria-expanded="false" aria-controls="ui-basic">
                            <span class="menu-arrow gh">
                                <i class="mdi mdi-chevron-down"></i>
                            </span>
                        </a>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="#buat-album">
                                    <span class="menu-icon">
                                        <span class="mdi mdi-plus-circle-outline submenu"></span>
                                    </span>
                                    <span class="menu-title">Buat Album</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis/unggahAudio">
                        <span class="menu-icon">
                            <i class="mdi mdi-music-note-plus"></i>
                        </span>
                        <span class="menu-title">Unggah</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis/penghasilan">
                        <span class="menu-icon">
                            <i class="mdi mdi-cash-multiple"></i>
                        </span>
                        <span class="menu-title">Penghasilan</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis/verified">
                        <span class="menu-icon">
                            <i class="mdi mdi-account-check-outline"></i>
                        </span>
                        <span class="menu-title">Verifikasi</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis/riwayat">
                        <span class="menu-icon">
                            <i class="mdi mdi-clock-outline"></i>
                        </span>
                        <span class="menu-title">Riwayat</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="{{ route('peraturan.artis') }}">
                        <span class="menu-icon">
                            <i class="mdi mdi-information-outline"></i>
                        </span>
                        <span class="menu-title">Informasi</span>
                    </a>
                </li>
            </ul>
            <footer
                style="background-color: #6c6c6c; color: #957DAD; width: 100%; position: fixed; bottom: 0; height: 85px;"
                id="lagu-diputar">
                <div class="music-player">
                    <div class="song-bar">
                        <div class="song-infos">
                            <div class="image-container1">
                                <img src="https://d2y6mqrpjbqoe6.cloudfront.net/image/upload/f_auto,q_auto/media/library-400/216_636967437355378335Your_Lie_Small_hq.jpg"
                                    alt="" id="track_image" />
                            </div>
                            <div class="song-description">
                                <p id="title">
                                    Watashitachi
                                </p>
                                <p id="artist">Masaru Yokoyama</p>
                            </div>
                        </div>
                    </div>
                    <div class="progress-controller">
                        <div class="control-buttons">
                            <div id="controls">
                                <button onclick="shuffle_song()" id="shuffle_button"><i class="fa fa-shuffle"
                                        aria-hidden="true"></i></button>
                                <button onclick="previous_song()" id="pre"><i class="fa fa-step-backward"
                                        aria-hidden="true"></i></button>
                                    <button onclick="justplay()" id="play"><i class="far fa-play-circle fr"
                                            aria-hidden="true"></i></button>
                                <button onclick="next_song()" id="next"><i class="fa fa-step-forward"
                                        aria-hidden="true"></i></button>
                            </div>
                        </div>
                        <div class="progress-container">
                            <span id="current-time" class="durasi">00:00</span>
                            <div class="progress-bar">
                                <div class="duration">
                                    <input type="range" class="progress" min="0" step="1"
                                        max="100" value="0" id="duration_slider"
                                        onchange="change_duration()">
                                </div>
                            </div>
                            <span id="duration" class="durasi">00:00</span>
                        </div>
                    </div>

                    <div class="other-features">
                        <div class="volume-bar">
                            <i class="mdi mdi-volume-high " onclick="mute_sound()" aria-hidden="true"
                                id="volume_icon"></i>
                            <input type="range" class="volume" min="0" max="100" step="1"
                                value="100" onchange="volume_change()" id="volume">
                            <p id="volume_show">100</p>

                        </div>
                    </div>
                </div>
            </footer>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <ul class="navbar-nav w-75">
                        <ul class="navbar-nav w-75">
                            <li class="nav-item w-75">
                                <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" method="POST"
                                    action="{{ route('pencarian.artis') }}">
                                    @csrf
                                    <div class="input-group">
                                        <span class="input-group-text"
                                            style="border-radius: 15px 0px 0px 15px; border: 1px solid #eaeaea">
                                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M18 18L13.9865 13.9795M16.2105 8.60526C16.2105 12.8055 12.8055 16.2105 8.60526 16.2105C4.40499 16.2105 1 12.8055 1 8.60526C1 4.40499 4.40499 1 8.60526 1C12.8055 1 16.2105 4.40499 16.2105 8.60526Z"
                                                    stroke="#957DAD" stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </span>
                                        <input type="text" id="search" name="search" class="form-control"
                                            placeholder="cari di sini" style="border-radius: 0px 15px 15px 0px" value="{{ old('search') }}" >
                                    </div>
                                </form>
                                <ul id="search-results"></ul>
                            </li>
                        </ul>
                    </ul>

                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown"
                                href="#" data-toggle="dropdown">
                                <i class="mdi mdi-bell"></i>
                                @if (count($notifs) > 0)
                                    <span class="count bg-danger"></span>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="notificationDropdown">
                                @php
                                    $shownNotifications = [];
                                @endphp
                                @foreach ($notifs->reverse() as $item)
                                    @if ($item->created_at)
                                        @php
                                            $createdAt = $item->created_at->format('Y-m-d');
                                            $title = $item->title;
                                            $notificationKey = $createdAt . '_' . $title;
                                        @endphp

                                        @if (!in_array($notificationKey, $shownNotifications))
                                            @php
                                                $shownNotifications[] = $notificationKey;
                                            @endphp

                                            @if ($item->type == 'lagu')
                                                <div class="dropdown-item preview-item" style="cursor: auto;">
                                                    <div>
                                                        <img src="{{ asset('storage/' . $item->song->image) }}"
                                                            class="avatarnotif">
                                                    </div>
                                                    <div class="preview-item-content" style="margin-right: 5px">
                                                        <p class="preview-subject mb-1" style="font-weight: bold">
                                                            {{ $item->title }}</p>
                                                    </div>
                                                    <button type="submit" class="btn btnicon p-0"
                                                        style="background: none; border: none; margin-bottom: 3px;"
                                                        onclick="">
                                                        <a href="/artis/delete-notif/{{ $item->code }}">
                                                            <i class="far fa-times-circle text-danger"
                                                                style="font-size: 11px;"></i>
                                                        </a>
                                                    </button>
                                                </div>
                                            @endif
                                            @if ($item->type == 'verifikasi')
                                                <div class="dropdown-item preview-item" style="cursor: auto;">
                                                    <div>
                                                        <img src="{{ asset('storage/' . $item->user->avatar) }}"
                                                            class="avatarnotif">
                                                    </div>
                                                    <div class="preview-item-content" style="margin-right: 5px">
                                                        <p class="preview-subject mb-1" style="font-weight: bold">
                                                            {{ $item->title }}</p>
                                                        <span class="text-muted ellipsis mb-0"
                                                            style="font-size: 12px; font-weight: normal; cursor: pointer;"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#alasan-{{ $item->code }}">Klik
                                                            untuk melihat alasan</span>
                                                    </div>
                                                    <button type="submit" class="btn btnicon p-0"
                                                        style="background: none; border: none; margin-bottom: 3px;"
                                                        onclick="">
                                                        <a href="/artis/delete-notif/{{ $item->code }}">
                                                            <i class="far fa-times-circle text-danger"
                                                                style="font-size: 11px;"></i>
                                                        </a>
                                                    </button>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                                <div class="navbar-profile profile-picture">
                                    <img class="img-xs rounded-circle"
                                        src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="profileDropdown">
                                <div class="p-3 mb-0 gap-3"
                                    style="display: flex; flex-direction: row; justify-content: center; align-items: center;">
                                    <img class="img-xs rounded-circle" style="object-fit: cover;"
                                        src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name"
                                        style="width: 60px; overflow: hidden; text-overflow: ellipsis; height: 15px;">
                                        {{ auth()->user()->name }}
                                    </p>
                                </div>
                                <a href="{{ route('ubah.profile.artis', auth()->user()->code) }}"
                                    class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon">
                                            <i class="mdi mdi-account-circle-outline"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1 fw-light">Profile</p>
                                    </div>
                                </a>
                                <a class="dropdown-item preview-item" href="{{ route('logout') }}">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon rounded-circle">
                                            <i class="mdi mdi-logout"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1 fw-light">Log out</p>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>

            @include('sweetalert::alert')
            @yield('content')


            {{-- <button id="playButton">Play</button>
            <button id="pauseButton">Pause</button>
            <input type="range" id="progress" min="0" value="0">
            <span id="currentTime">0:00</span> / <span id="duration">0:00</span> --}}

            <div id="buat-album">
                <div class="card window">
                    <div class="card-body">
                        <a href="#" class="close-button far fa-times-circle"></a>
                        <h3 class="judulnottebal">Buat Album</h3>
                        <form class="row" action="{{ route('tambah.album.artis', auth()->user()->code) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <h6 class="form-label judulnottebal">Nama Album</h6>
                                    <input type="text" name="name" class="form-control" id="namaproyek"
                                        placeholder="Masukkan nama kategori musik" maxlength="55" required>
                                </div>
                                <div class="mb-3">
                                    <h6 for="upload" class="form-label judulnottebal">Upload
                                        Foto</h6>
                                    <input type="file" name="image" class="form-control" id="namaproyek"
                                        accept="image/*" required>
                                </div>
                            </div>
                            <div class="text-md-right">
                                <button class="btn" type="submit">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @foreach ($notifs as $item)
                <div class="modal fade" id="alasan-{{ $item->code }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header pb-0">
                                <h3 class="modal-title judul" style="font-size: 20px" id="exampleModalLabel">
                                    Pengajuan verifikasi
                                    akun ditolak
                                </h3>
                                <button type="button" style="background: none; border: none;"
                                    class="close-button far fa-times-circle" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </button>
                            </div>
                            <div class="modal-body pt-1">
                                <textarea class="form-control" rows="5" readonly>{{ $item->message }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

            <script>
                $(document).ready(function() {
                    $('#search_song').on('keyup', function() {
                        var query = $(this).val();
                        var id = $('#album_id').val()
                        $.ajax({
                            url: '/artis/search_song/',
                            type: 'GET',
                            data: {
                                query: query,
                                id: id,
                            },
                            dataType: 'json',
                            success: function(response) {
                                var results = response.results;
                                var $previewList = $('.preview-list');
                                $previewList.empty();

                                $.each(results, function(index, result) {
                                    var $previewItem = $(
                                        '<div class="preview-item" data-song-id="' + result
                                        .id + '">');

                                    $previewItem.append(
                                        '<div class="preview-thumbnail"><img src="http://127.0.0.1:8000/storage/' +
                                        result.image + '" width="10%"></div>');
                                    $previewItem.append(
                                        '<div class="preview-item-content d-sm-flex flex-grow"><div class="flex-grow"><h6 class="preview-subject">' +
                                        result.judul + '</h6><p class="text-muted mb-0">' +
                                        result.artist.user.name +
                                        '</p></div><div class="mr-auto text-sm-right pt-2 pt-sm-0"><div class="text-group"><i onclick="myFunction(this)" class="far fa-heart pr-2"></i><p>' +
                                        result.waktu +
                                        `</p>

                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#staticBackdrop-${result.code}"
                                                            style="color: #957dad">
                                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px"
                                                                y="0px" width="20" height="20"
                                                                viewBox="0 2 24 24">
                                                                <path fill="#957DAD"
                                                                    d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 11 7 L 11 11 L 7 11 L 7 13 L 11 13 L 11 17 L 13 17 L 13 13 L 17 13 L 17 11 L 13 11 L 13 7 L 11 7 z">
                                                                </path>
                                                            </svg>
                                                        </a>

                                        </div></div></div>`
                                    );

                                    $previewList.append($previewItem);
                                });
                            }
                        });
                    });
                });

                $(document).ready(function() {
                    $('#search').on('keyup', function() {
                        var query = $(this).val();
                        $.ajax({
                            url: '/artis/search/',
                            type: 'GET',
                            data: {
                                query: query
                            },
                            dataType: 'json',
                            success: function(response) {
                                // console.log(data);
                                var results = response.results;
                                var $searchResults = $('#search-results');
                                $searchResults.empty();
                                $.each(results.songs, function(index, result) {
                                    $searchResults.append(
                                        `<li><a href='/artis/search/${result.code}'>${result.judul}</a></li>`
                                    );
                                });
                                $.each(results.artists, function(index, result) {
                                    $searchResults.append(
                                        `<li><a href='/artis/search/${result.code}'>${result.name}</a></li>`
                                    );
                                });
                            }
                        });
                    });
                });
            </script>

            <script>
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $(document).ready(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: `/artist/check`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            response.forEach(function(item) {
                                let artistId = item.artist_id;
                                let like = document.getElementById(`like-artist${item.artist_id}`);
                                like.classList.toggle('fas');
                            })
                        },
                        error: function(response) {
                            console.log(response)
                        }
                    });
                    $.ajax({
                        url: `/artist/count`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            let totalLikes = 0;
                            response.forEach(function(item) {
                                totalLikes += item.likes;
                                let artistId = item.artist_id;
                            })
                            let count = document.getElementById('likeCount');
                            if (count) {
                                count.textContent = totalLikes;
                            }
                        },
                        error: function(response) {}
                    })
                });

                function likeArtist(iconElement, artistId) {
                    let isLiked = iconElement.classList.contains('fas');
                    $.ajax({
                        url: `/artist/${artistId}/like`,
                        type: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                const likeCountElement = document.getElementById(`likeCount${artistId}`);
                                if (likeCountElement) {
                                    likeCountElement.textContent = response.likes;
                                }
                                if (isLiked) {
                                    iconElement.classList.remove('fas');
                                    iconElement.classList.add('far');
                                } else {
                                    iconElement.classList.remove('far');
                                    iconElement.classList.add('fas');
                                }
                                updateLikeStatus(artistId, !isLiked);
                            }
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    })
                }

                function updateLikeStatus(artistId, isLiked) {
                    let likeIcons = document.querySelectorAll(`.like[data-id="${artistId}"]`);
                    likeIcons.forEach(likeIcon => {
                        likeIcon.classList.toggle('fas', isLiked);
                        likeIcon.classList.toggle('far', !isLiked);
                    });
                }
            </script>

            {{-- <script>
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $(document).ready(function() {
                    $.ajax({
                        url: `/song/check`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            response.forEach(function(item) {
                                let songId = item.song_id;
                                let like = document.getElementById(`like${item.song_id}`);
                                like.classList.toggle('fas');
                            })
                        }
                    });
                });
                $(document).ready(function() {
                    $.ajax({
                        url: `/song/check`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            response.forEach(function(item) {
                                let songId = item.song_id;
                                let like = document.getElementById(`like-2${item.song_id}`);
                                if (like) {
                                    like.classList.toggle('fas');
                                }
                            })
                        }
                    });
                });
                $(document).ready(function() {
                    $.ajax({
                        url: `/song/check`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            response.forEach(function(item) {
                                let songId = item.song_id;
                                let like = document.getElementById(`like-3${item.song_id}`);
                                if (like) {
                                    like.classList.toggle('fas');
                                }
                            })
                        }
                    });
                });
                $(document).ready(function() {
                    $.ajax({
                        url: `/song/check`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            response.forEach(function(item) {
                                let songId = item.song_id;
                                let like = document.getElementById(`like-suka${item.song_id}`);
                                if (like) {
                                    like.classList.toggle('fas');
                                }
                            })
                        }
                    });
                });

                function toggleLike(iconElement, songId) {
                    let isLiked = iconElement.classList.contains('fas');

                    $.ajax({
                        url: `/song/${songId}/like`,
                        type: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                if (isLiked) {
                                    iconElement.classList.remove('fas');
                                    iconElement.classList.add('far');
                                } else {
                                    iconElement.classList.remove('far');
                                    iconElement.classList.add('fas');
                                }
                            }
                        }
                    })
                }


                function updateSongLikeStatus(songId, isLiked) {
                    let likeIcons = document.querySelectorAll(`.shared-icon-like[data-id="${songId}"]`);
                    likeIcons.forEach(likeIcon => {
                        likeIcon.classList.toggle('fas', isLiked);
                        likeIcon.classList.toggle('far', !isLiked);
                    });
                }
            </script> --}}


            {{-- <script>
                let previous = document.querySelector('#pre');
                let play = document.querySelector('#play');
                let next = document.querySelector('#next');
                let title = document.querySelector('#title');
                let artist = document.querySelector('#artist');

                let muteButton = document.querySelector('#volume_icon')
                let recent_volume = document.querySelector('#volume');
                let volume_show = document.querySelector('#volume_show');

                let slider = document.querySelector('#duration_slider');
                let show_duration = document.querySelector('#show_duration');
                let track_image = document.querySelector('#track_image');
                let shuffleButton = document.querySelector('#shuffle_button');
                let auto_play = document.querySelector('#auto');

                let timer;
                let autoplay = 1;
                let playCount = 0;
                let prevVolume;
                let currentTime = 1;

                let index_no = 0;
                let Playing_song = false;

                // create a audio element
                let track = document.createElement('audio');


                let All_song = [];

                // const playButton = document.getElementById('playButton');
                // const pauseButton = document.getElementById('pauseButton');
                // const progress = document.getElementById('progress');
                // const currentTime = document.getElementById('currentTime');
                // const duration = document.getElementById('duration');

                // function ambilDataLagu() {
                // fetch('/ambil-lagu')
                //     .then(response => response.json())
                //     .then(data => {
                //         All_song = data.map(lagu => {
                //             return {
                //                 id: lagu.id,
                //                 judul: lagu.judul,
                //                 audio: lagu.audio,
                //                 image: lagu.image,
                //                 artistId: lagu.artist.user.name
                //             };
                //         });
                //         play_song()
                //     })
                //     .catch(error => {
                //         console.error('Error fetching data:', error);
                //     });
                // // }

                // function play_song() {
                //     const audioUrls = All_song.map(song => song.audio);
                //     console.log(audioUrls);
                //     const sound = new Howl({
                //         src: [
                //             ['http://127.0.0.1:8000/storage/musics/h0dTC0RQfUHTqfgHm7ncF54rwjo83T94eBdv1pxQ.mp3']
                //         ],
                //         html5: true,
                //         onplay: () => {
                //             playButton.disabled = true;
                //             pauseButton.disabled = false;
                //         },
                //         onpause: () => {
                //             playButton.disabled = false;
                //             pauseButton.disabled = true;
                //         },
                //         onend: () => {
                //             playButton.disabled = false;
                //             pauseButton.disabled = true;
                //         },
                //         onload: () => {
                //             // The audio file is loaded, so we can update the duration
                //             duration.textContent = formatTime(sound.duration());
                //         },
                //         onseek: () => {
                //             updateUI();
                //         }
                //     });

                //     playButton.addEventListener('click', () => {
                //         sound.play();
                //     });

                //     pauseButton.addEventListener('click', () => {
                //         sound.pause();
                //     });

                //     sound.on('play', () => {
                //         // Start a timer to update the progress bar and current time
                //         updateProgressInterval = setInterval(updateUI, 100);
                //     });

                //     sound.on('pause', () => {
                //         // Clear the timer when paused
                //         clearInterval(updateProgressInterval);
                //     });

                //     progress.addEventListener('input', () => {
                //         const seekTime = (progress.value / 100) * sound.duration();
                //         sound.seek(seekTime);
                //         updateUI();
                //     });

                //     let updateProgressInterval;

                //     function updateUI() {
                //         const currentTimeValue = sound.seek();
                //         const durationValue = sound.duration();

                //         const percentage = (currentTimeValue / durationValue) * 100;
                //         progress.value = isNaN(percentage) ? 0 : percentage;
                //         currentTime.textContent = formatTime(currentTimeValue);
                //     }

                //     function formatTime(seconds) {
                //         const minutes = Math.floor(seconds / 60);
                //         const remainingSeconds = Math.floor(seconds % 60);
                //         return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
                //     }
                // }

                $.ajax({
                    url: '/ambil-lagu',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        All_song = data.map(lagu => {
                            return {
                                id: lagu.id,
                                judul: lagu.judul,
                                audio: lagu.audio,
                                image: lagu.image,
                                artistId: lagu.artist.user.name
                            };
                        });
                        console.log("data lagu yang diambil:", All_song);
                        if (All_song.length > 0) {
                            // Memanggil load_track dengan indeks 0 sebagai lagu pertama
                            load_track(0);
                        } else {
                            console.error("Data lagu kosong.");
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });

                console.log("audio media -> ", slider);

                ambilDataLagu();

                // function load the track
                function load_track(index_no) {
                    if (index_no >= 0 && index_no < All_song.length) {
                        console.log("tester " + index_no);
                        track.src = '{{ asset('storage') }}' + '/' + All_song[index_no].audio;
                        title.innerHTML = All_song[index_no].judul;
                        artist.innerHTML = All_song[index_no].artistId;
                        track_image.src = '{{ asset('storage') }}' + '/' + All_song[index_no].image;
                        track.load();
                        timer = setInterval(range_slider, 1000);
                    } else {
                        console.log(All_song.length);
                        console.error("Index_no tidak valid.");
                    }
                }

                load_track(0);

                // fungsi mute sound
                function mute_sound() {
                    if (track.volume === 0) {
                        track.volume = prevVolume;
                        recent_volume.value = prevVolume * 100;
                    } else {
                        prevVolume = track.volume;
                        track.volume = 0;
                        recent_volume.value = 0;
                    }
                    updateMuteButtonIcon();
                }

                // fungsi untuk memeriksa lagu diputar atau tidak
                function justplay() {
                    if (Playing_song == false) {
                        playsong();
                    } else {
                        pausesong();
                    }
                }

                // reset song slider
                function reset_slider() {
                    slider.value = 100;
                }

                // play song
                function playsong() {
                    if (track.paused) {
                        track.play();
                        Playing_song = true;
                        play.innerHTML = '<i class="far fa-pause-circle fr" aria-hidden="true"></i>';
                    } else {
                        track.pause();
                        Playing_song = false;
                        play.innerHTML = '<i class="far fa-play-circle" aria-hidden="true"></i>';
                    }

                    // Periksa apakah index_no memiliki nilai yang benar
                    if (index_no >= 0 && index_no < All_song.length) {
                        // Perbarui playCount dengan songId yang sesuai
                        let songId = All_song[index_no].id;
                        console.log(All_song[index_no])
                        updatePlayCount(songId);
                        history(songId);

                    }
                    track.addEventListener('timeupdate', updateDuration);
                    playCount++;
                }

                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                function updatePlayCount(songId) {
                    fetch(`/update-play-count/${songId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Play count updated:', data.message);
                        })
                        .catch(error => {
                            // Tangani error jika diperlukan
                            console.error('Error updating play count:', error);
                        });
                }

                function history(songId) {
                    console.log('Mengirim riwayat untuk songId:', songId);
                    $.ajax({
                        url: '/simpan-riwayat',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            song_id: songId,
                        },
                        success: function(response) {
                            console.log('Respon dari simpan-riwayat:', response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error saat mengirim riwayat:', error);
                        }
                    });
                }

                shuffleButton.addEventListener('click', function() {
                    shuffle_song();
                });


                function shuffle_song() {
                    let currentIndex = All_song.length,
                        randomIndex, temporaryValue;

                    if (track.paused === false) {
                        track.pause();
                    }

                    // Selama masih ada elemen untuk diacak
                    while (currentIndex !== 0) {
                        // Pilih elemen yang tersisa secara acak
                        randomIndex = Math.floor(Math.random() * currentIndex);
                        currentIndex--;

                        // Tukar elemen terpilih dengan elemen saat ini
                        temporaryValue = All_song[currentIndex];
                        All_song[currentIndex] = All_song[randomIndex];
                        All_song[randomIndex] = temporaryValue;
                    }
                    // Setel ulang indeks lagu saat ini ke 0
                    index_no = 0;
                    // Memuat lagu yang diacak
                    load_track(index_no);
                    playsong();
                }
                // pause song
                function pausesong() {
                    track.pause();
                    Playing_song = false;
                    play.innerHTML = '<i class="far fa-play-circle" aria-hidden="true"></i>'
                }

                function putar(id) {
                    console.log('ID yang dikirim:', id);
                    id = id - 1;
                    let lagu = All_song[id];
                    // alert(All_song.length - 1 + " " + id);
                    if (lagu) {
                        let new_index_no = All_song.indexOf(lagu);
                        if (new_index_no >= 0) {
                            index_no = new_index_no;
                            load_track(id);
                            playsong();
                        } else {
                            index_no = 0;
                            load_track(index_no);
                            playsong();
                        }
                    } else {
                        console.error('Lagu dengan ID ' + id + ' tidak ditemukan dalam data lagu.');
                    }
                }

                track.addEventListener('ended', function() {
                    // Panggil fungsi untuk memutar lagu selanjutnya
                    next_song();
                });

                // fungsi untuk memutar lagu sesudahnya
                function next_song() {
                    if (index_no < All_song.length - 1) {
                        index_no += 1;
                    } else {
                        index_no = 0;
                    }
                    load_track(index_no);
                    playsong();
                    if (autoplay == 1) {
                        // Set interval sebelum memulai lagu selanjutnya
                        setTimeout(function() {
                            track.play();
                        }, 1000); // Delay 1 detik sebelum memulai lagu selanjutnya
                    }
                }

                // fungsi untuk memutar lagu sebelumnya
                function previous_song() {
                    if (index_no > 0) {
                        index_no -= 1;
                    } else {
                        index_no = All_song.length - 1;
                    }
                    load_track(index_no);
                    playsong();
                }

                // ubah volume
                function volume_change() {
                    volume_show.innerHTML = recent_volume.value;
                    track.volume = recent_volume.value / 100;
                }

                function change_duration() {
                    let slider_value = parseInt(slider.value);
                    if (!isNaN(track.duration) && isFinite(slider_value)) {
                        // track.duration * (slider_value / 100);
                        // console.log(slider);
                        slider.currentTime = track.duration * (slider_value / 100);
                        console.log(slider.currentTime);
                    }
                }

                slider.addEventListener('click', function() {
                    change_duration();
                    clearInterval(timer);
                    Playing_song = true;
                    play.innerHTML = '<i class="far fa-pause-circle fr" aria-hidden="true"></i>';
                    track.addEventListener('timeupdate', updateDuration)
                    track.play();
                })

                // range slider
                function range_slider() {
                    let position = 0;
                    if (!isNaN(track.duration)) {
                        position = track.currentTime * (100 / track.duration);
                        slider.value = position;
                    }
                    if (track.ended) {
                        play.innerHTML = '<i class="far fa-play-circle" aria-hidden="true"></i>';
                        if (autoplay == 1) {
                            index_no += 1;
                            load_track(index_no);
                            playsong();
                        }
                    }

                    // kalkulasi waktu dari durasi audio
                    let durationElement = document.getElementById('duration');
                    let durationMinutes = Math.floor(track.duration / 60);
                    let durationSeconds = Math.floor(track.duration % 60);
                    let formattedDuration = `${durationMinutes}:${durationSeconds < 10 ? '0' : ''}${durationSeconds}`;
                    durationElement.textContent = formattedDuration;
                }

                track.addEventListener('timeupdate', range_slider);

                // fungsi ini akan dijalankan ketika lagu selesai (mengubah icon play menjadi pause)
                if (track.ended) {
                    play.innerHTML = '<i class="fa fa-play-circle" aria-hidden="true"></i>';
                    if (autoplay == 1) {
                        index_no += 1;
                        load_track(index_no);
                        playsong();
                    }
                }

                // Fungsi untuk mengupdate durasi waktu (waktu berjalan sesuai real time)
                function updateDuration() {
                    // Menghitung durasi waktu yang telah berlalu
                    let currentMinutes = Math.floor(track.currentTime / 60);
                    let currentSeconds = Math.floor(track.currentTime % 60);
                    // Memformat durasi waktu yang akan ditampilkan
                    let formattedCurrentTime = `${currentMinutes}:${currentSeconds < 10 ? '0' : ''}${currentSeconds}`;
                    // console.log(formattedCurrentTime);
                    // Menampilkan durasi waktu pada elemen yang sesuai
                    let currentTimeElement = document.getElementById('current-time');
                    currentTimeElement.textContent = formattedCurrentTime;
                }

                // Fungsi yang dipanggil saat audio selesai dimainkan
                function onTrackEnded() {

                    // Menghapus event listener setelah audio selesai dimainkan
                    track.removeEventListener('timeupdate', updateDuration);
                }

                // Event listener for mute button
                muteButton.addEventListener('click', function() {
                    mute_sound();
                    updateMuteButtonIcon();
                });

                recent_volume.addEventListener('input', function() {
                    // Calculate volume value based on slider position
                    let slider_value = recent_volume.value / 100;
                    track.volume = slider_value;


                    // Update mute button icon and volume display
                    updateMuteButtonIcon();
                    volume_show.innerHTML = Math.round(slider_value * 100);
                });

                console.log("SLIDER VALUE ->" + recent_volume);

                // Function to update mute button icon
                function updateMuteButtonIcon() {
                    if (track.volume === 0) {
                        muteButton.classList.remove('mdi-volume-heigh');
                        muteButton.classList.add('mdi-volume-off');
                        volume_show.innerHTML = 0;
                    } else {
                        muteButton.classList.remove('mdi-volume-off');
                        muteButton.classList.add('mdi-volume-heigh');
                        volume_show.innerHTML = Math.round(track.volume * 100);
                        recent_volume.value = track.volume * 100;
                    }
                }
            </script> --}}

            <script src="/user/assets/vendors/js/vendor.bundle.base.js"></script>
            <script src="/user/assets/vendors/chart.js/Chart.min.js"></script>
            <script src="/user/assets/vendors/progressbar.js/progressbar.min.js"></script>
            <script src="/user/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
            <script src="/user/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
            <script src="/user/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
            <script src="/user/assets/js/off-canvas.js"></script>
            <script src="/user/assets/js/hoverable-collapse.js"></script>
            <script src="/user/assets/js/misc.js"></script>
            <script src="/user/assets/js/settings.js"></script>
            <script src="/user/assets/js/todolist.js"></script>
            <script src="/user/assets/js/dashboard.js"></script>
</body>

</html>
