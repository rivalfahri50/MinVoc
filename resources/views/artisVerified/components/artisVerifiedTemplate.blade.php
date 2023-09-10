<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="/user/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/user/assets/css/style.css">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="shortcut icon" href="/image/favicon.svg" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,400;0,500;1,100;1,200&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
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


        /* Style Untuk Ukuran foto profil */
        .profile-picture {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
    </style>
    <script>
        // INI SCRIPT UNTUK HASIL SEARCH TAMPIL/TIDAK
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("search");
            const searchResults = document.getElementById("search-results");

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
                <a class="sidebar-brand brand-logo" href="/artis-verified/dashboard"><img
                        src="/user/assets/images/logo.svg" alt="logo" /></a>
            </div>
            <ul class="nav">
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis-verified/dashboard">
                        <span class="menu-icon ">
                            <i class="mdi mdi-home"></i>
                        </span>
                        <span class="menu-title">Beranda</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis-verified/playlist">
                        <span class="menu-icon">
                            <i class="mdi mdi-music"></i>
                        </span>
                        <span class="menu-title">Album</span>
                        <a href="#ui-basic" data-toggle="collapse" aria-expanded="false" aria-controls="ui-basic">
                            <span class="menu-arrow">
                                <i class="mdi mdi-chevron-right"></i>
                            </span>
                        </a>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                {{-- <a class="nav-link" href="{{ route('buat.playlist.artisVerified') }}">
                                    <span class="menu-icon">
                                        <i class="mdi mdi-plus-circle-outline"></i>
                                    </span>
                                    <span class="menu-title">Buat Playlist</span>
                                </a> --}}
                                <a class="nav-link" href="#buat-album">
                                    <span class="menu-icon">
                                        <i class="mdi mdi-plus-circle-outline"></i>
                                    </span>
                                    <span class="menu-title">Buat Album</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis-verified/unggahAudio">
                        <span class="menu-icon">
                            <i class="mdi mdi-music-note-plus"></i>
                        </span>
                        <span class="menu-title">Unggah</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis-verified/kolaborasi">
                        @if ($title === 'kolaborasi')
                            <span class="menu-icon">
                                <i class="mdi mdi-account-group-outline"></i>
                            </span>
                        @else
                            <span class="menu-icon">
                                <i class="mdi mdi-account-group-outline"></i>
                            </span>
                            <span class="menu-title">Kolaborasi</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis-verified/penghasilan">
                        <span class="menu-icon">
                            <i class="mdi mdi-cash-multiple"></i>
                        </span>
                        <span class="menu-title">Penghasilan</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis-verified/riwayat">
                        <span class="menu-icon">
                            <i class="mdi mdi-clock-outline"></i>
                        </span>
                        <span class="menu-title">Riwayat</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="{{ route('peraturan.artisVerified') }}">
                        <span class="menu-icon">
                            <i class="mdi mdi-information-outline"></i>
                        </span>
                        <span class="menu-title">Peraturan</span>
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
                        {{-- <div class="icons">
                        <i id="audio-player-like-icon like"
                            class="shared-icon-like fas fa-heart fr fh"
                            data-id="" onclick="toggleLike(this)"></i>
                    </div> --}}
                    </div>
                    <div class="progress-controller">
                        <div class="control-buttons">
                            <div id="controls">
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
                                action="{{ route('pencarian.artisVerified') }}">
                                @csrf
                                    <div class="input-group mb-3">
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
                                            placeholder="cari di sini" style="border-radius: 0px 15px 15px 0px">
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
                                <span class="count bg-danger"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="notificationDropdown">
                                <a href="#" class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon rounded-circle">
                                            <img src="/user/assets/images/faces/face12.jpg">
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Gajah</p>
                                        <p class="text-muted ellipsis mb-0"> Tulus </p>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon rounded-circle">
                                            <img src="/user/assets/images/faces/face12.jpg">
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Gajah</p>
                                        <p class="text-muted ellipsis mb-0"> Tulus </p>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon rounded-circle">
                                            <img src="/user/assets/images/faces/face12.jpg">
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Gajah</p>
                                        <p class="text-muted ellipsis mb-0"> Tulus </p>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle"
                                        src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="profileDropdown">
                                <div class="p-3 mb-0 gap-3"
                                    style="display: flex; flex-direction: row; justify-content: center; align-items: center;">
                                    <img class="img-xs rounded-circle"
                                        src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ auth()->user()->name }}
                                    </p>
                                </div>
                                <a href="{{ route('ubah.profile.artisVerified', auth()->user()->code) }}"
                                    class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon">
                                            <i class="mdi mdi-account-circle-outline"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Profile</p>
                                    </div>
                                </a>
                                <a class="dropdown-item preview-item" href="{{ route('logout.users') }}">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon rounded-circle">
                                            <i class="mdi mdi-logout"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Log out</p>
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

            @yield('content')

            <div id="buat-album">
                <div class="card window">
                    <div class="card-body">
                        <a href="" class="close-button far fa-times-circle"></a>
                        <h2 class="judul">Buat Album</h2>
                        <form class="row" action="{{ route('tambah.album.artisVerified', auth()->user()->code) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <h3 class="form-label judul">Nama Album</h3>
                                    <input type="text" name="name" class="form-control" id="namaproyek"
                                        placeholder="Masukkan nama kategori musik" required>
                                </div>
                                <div class="mb-3">
                                    <h3 for="upload" class="form-label judul">Upload
                                        Foto</h3>
                                    <input type="file" name="image" class="form-control" id="namaproyek"
                                        required>
                                </div>
                            </div>
                            <div class="text-md-right">
                                <button class="btn" type="submit">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

            <script>
                $(document).ready(function() {
                    $('#search_song').on('keyup', function() {
                        var query = $(this).val();
                        $.ajax({
                            url: '/artis/search_song/',
                            type: 'GET',
                            data: {
                                query: query
                            },
                            dataType: 'json',
                            success: function(response) {
                                var results = response.results;
                                var $searchResults = $('#search-results-song');
                                $searchResults.empty();


                                $.each(results, function(index, result) {
                                    $searchResults.append('<li>' + result.judul + '</li>');
                                });
                            }
                        });
                    });
                });

                $(document).ready(function() {
                    $('#search').on('keyup', function() {
                        var query = $(this).val();
                        $.ajax({
                            url: '/artis-verified/search/',
                            type: 'GET',
                            data: {
                                query: query
                            },
                            dataType: 'json',
                            success: function(response) {
                                var results = response.results;
                                var $searchResults = $('#search-results');
                                $searchResults.empty();
                                $.each(results.songs, function(index, result) {
                                    $searchResults.append(
                                        `<li><a href='/artis-verified/search/${result.code}'>${result.judul}</a></li>`
                                    );
                                });
                                $.each(results.artists, function(index, result) {
                                    $searchResults.append(
                                        `<li><a href='/artis-verified/search/${result.code}'>${result.name}</a></li>`
                                    );
                                });
                            }
                        });
                    });
                });
                $(document).ready(function() {
                    $('.menu-arrow').click(function() {
                        $(this).find('i').toggleClass('mdi-chevron-right mdi-chevron-down');
                    });
                });
            </script>

            <script>
                $(document).ready(function() {
                    $.ajax({
                        url: `/song/check`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            response.forEach(function(item) {
                                const songId = item.song_id;
                                const like = document.getElementById(`like${item.song_id}`);
                                like.classList.toggle('fas');
                            })
                        }
                    });
                });

                function toggleLike(iconElement, songId) {
                    iconElement.classList.toggle('fas');
                    iconElement.classList.toggle('far');

                    const isLiked = iconElement.classList.contains('fas');

                    // updateSongLikeStatus(songId, isLiked);
                    // const sharedHeartIcons = document.querySelectorAll('.shared-icon-like');
                    // sharedHeartIcons.forEach(heartIcon => {
                    //     heartIcon.classList.toggle('fas', isLiked);
                    //     heartIcon.classList.toggle('far', !isLiked);
                    // });

                    fetch(`/song/${songId}/like`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken

                            },
                            body: JSON.stringify({
                                isLiked: iconElement.classList.contains('fas')
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // updateSongLikeStatus(songId, isLiked);

                            const audioPlayerLikeIcon = document.getElementById('audio-player-like-icon');
                            if (audioPlayerLikeIcon) {
                                audioPlayerLikeIcon.classList.toggle('fas', isLiked);
                                audioPlayerLikeIcon.classList.toggle('far', !isLiked);
                            }

                        })
                        .catch(error => {
                            // console.error('Error:', error);
                        });
                }
                // alert("beeeeeee");
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                function updateSongLikeStatus(songId, isLiked) {
                    const likeIcons = document.querySelectorAll(`.shared-icon-like[data-song-id="${songId}"]`);
                    likeIcons.forEach(likeIcon => {
                        likeIcon.classList.toggle('fas', isLiked);
                        likeIcon.classList.toggle('far', !isLiked);
                    });
                }
            </script>
            <script>
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

                let auto_play = document.querySelector('#auto');
                // let present = document.querySelector('#present');
                // let total = document.querySelector('#total');
                // let audio = document.querySelector('audio');

                let timer;
                let autoplay = 0;
                let playCount = 0;
                let prevVolume;

                let index_no = 0;
                let Playing_song = false;

                // create a audio element
                let track = document.createElement('audio');


                let All_song = [];

                function ambilDataLagu() {
                    fetch('/ambil-lagu')
                        .then(response => response.json())
                        .then(data => {
                            All_song = data.map(lagu => {
                                return {
                                    id: lagu.id,
                                    judul: lagu.judul,
                                    audio: lagu.audio,
                                    image: lagu.image,
                                    artistId: lagu.artist.user.name
                                };
                            });
                            console.log(All_song);
                            load_track(index_no);
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                        });
                }

                ambilDataLagu();
                // semua function

                // function load the track
                function load_track(index_no) {
                    clearInterval(timer)
                    reset_slider();
                    track.src = '{{ asset('storage') }}' + '/' + All_song[index_no].audio;
                    title.innerHTML = All_song[index_no].judul;
                    artist.innerHTML = All_song[index_no].artistId;
                    track_image.src = '{{ asset('storage') }}' + '/' + All_song[index_no].image;
                    track.load();

                    timer = setInterval(range_slider, 1000);
                    // total.innerHTML = All_song.length;
                    // present.innerHTML = index_no + 1;
                }

                load_track(index_no);

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
                    slider.value = 0;
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
                        const songId = All_song[index_no].id;
                        console.log(All_song[index_no])
                        updatePlayCount(songId);
                    }
                    track.addEventListener('timeupdate', updateDuration);
                    playCount++;
                }

                function updatePlayCount(songId) {
                    const headers = new Headers();
                    headers.append('X-CSRF-TOKEN', csrfToken);

                    fetch(`/update-play-count/${songId}`, {
                            method: 'POST',
                            headers: headers,
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

                // pause song
                function pausesong() {
                    track.pause();
                    Playing_song = false;
                    play.innerHTML = '<i class="far fa-play-circle" aria-hidden="true"></i>'
                }

                function putar(id) {
                    console.log('ID yang dikirim:', id);
                    id = id - 1;
                    const lagu = All_song[id];
                    // alert(All_song.length - 1 + " " + id);
                    if (lagu) {
                        const new_index_no = All_song.indexOf(lagu);
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

                // fungsi untuk memutar lagu sesudahnya
                function next_song() {
                    if (index_no < All_song.length - 1) {
                        index_no += 1;
                    } else {
                        index_no = 0;
                    }
                    load_track(index_no);
                    playsong();
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

                // ubah posisi slider
                function change_duration() {
                    let slider_position = track.duration * (slider.value / 100);
                    track.currentTime = slider_position;
                }

                // ubah volume
                function volume_change() {
                    volume_show.innerHTML = recent_volume.value;
                    track.volume = recent_volume.value / 100;
                }

                slider.addEventListener('input', function() {
                    change_duration();
                    clearInterval(timer);
                    track.currentTime = track.duration * (slider.value / 100);
                    Playing_song = true;
                    play.innerHTML = '<i class="far fa-pause-circle fr" aria-hidden="true"></i>';
                    track.addEventListener('timeupdate', updateDuration)
                    track.play();
                })

                // range slider
                function range_slider() {
                    let position = 0;
                    // memperbaharui posisi slider
                    if (!isNaN(track.duration)) {
                        position = track.currentTime * (100 / track.duration);
                        slider.value = position;
                        // console.log(track.duration);
                    }

                    if (track.ended) {
                        play.innerHTML = '<i class="far fa-play-circle" aria-hidden="true"></i>';
                        if (autoplay == 1) {
                            index_no += 1;
                            load_track(index_no);
                            playsong();
                            console.log(track.ended);
                        }
                    }

                    // kalkulasi waktu dari durasi audio
                    const durationElement = document.getElementById('duration');
                    const durationMinutes = Math.floor(track.duration / 60);
                    const durationSeconds = Math.floor(track.duration % 60);
                    const formattedDuration = `${durationMinutes}:${durationSeconds < 10 ? '0' : ''}${durationSeconds}`;
                    durationElement.textContent = formattedDuration;
                }

                // console.log(range_slider());

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
                    const currentMinutes = Math.floor(track.currentTime / 60);
                    const currentSeconds = Math.floor(track.currentTime % 60);

                    // Memformat durasi waktu yang akan ditampilkan
                    const formattedCurrentTime = `${currentMinutes}:${currentSeconds < 10 ? '0' : ''}${currentSeconds}`;

                    // Menampilkan durasi waktu pada elemen yang sesuai
                    const currentTimeElement = document.getElementById('current-time');
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
            </script>

            <script>
                function myFunction(x) {
                    x.classList.toggle("far");
                    x.classList.toggle("fas");
                    x.classList.toggle("warna-kostum-like");
                }
            </script>

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
        </div>
    </div>
</body>

</html>
