<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="/user/assets/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="/user/assets/vendors/mdi/css/materialdesignicons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="shortcut icon" href="/image/favicon.svg" type="image/x-icon">
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

        .untukpopup {
            width: 150px;
            height: 150px;
            position: relative;
            overflow: hidden;
            border: none;
            color: #957dad;
        }

        .untukpopup:hover {
            background-color: #69547d;
            color: #eaeaea;
        }

        #buatplaylist {
            width: 100%;
            height: 100%;
            position: fixed;
            background: rgba(0, 0, 0, 0.7);
            top: 0;
            left: 0;
            z-index: 9999;
            visibility: hidden;
        }

        .window {
            background-color: #ffffff;
            width: 500px;
            border-radius: 10px;
            position: relative;
            margin: 9% auto;
            padding: 10px;
        }

        .close-button {
            display: block;
            color: #957dad;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .noob {
            display: none;
        }

        .wadah {
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
        }

        .upload-label i {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .form-i {
            height: 25px;
            border-radius: 8px;
        }

        #buatplaylist:target {
            visibility: visible;
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
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="/pengguna/dashboard"><img src="/user/assets/images/logo.svg"
                        alt="logo" /></a>
            </div>
            <ul class="nav fixedbar">
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/pengguna/dashboard">
                        <span class="menu-icon ">
                            <i class="mdi mdi-home"></i>
                        </span>
                        <span class="menu-title">Beranda</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/pengguna/playlist">
                        <span class="menu-icon">
                            <i class="mdi mdi-music"></i>
                        </span>
                        <span class="menu-title">Playlist</span>
                        <a href="#ui-basic" data-toggle="collapse" aria-expanded="false" aria-controls="ui-basic">
                            <span class="menu-arrow gh">
                                <i class="mdi mdi-chevron-down"></i>
                            </span>
                        </a>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="#buatplaylist">
                                    <span class="menu-icon">
                                        <i class="mdi mdi-plus-circle-outline"  style="font-size: 20px;"></i>
                                    </span>
                                    <span class="menu-title">Buat Playlist</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    {{-- popupnya atas --}}
                    <div id="buatplaylist">
                        <div class="card window">
                            <div class="card-body">
                                <a href="#" class="close-button mdi mdi-close-circle-outline"></a>
                                <h3 class="judul">Buat Playlist</h2>
                                    <form class="row" action="{{ route('buat.playlist') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-4">
                                            <div class="card untukpopup">
                                                <label for="gambarplaylist" id="tampil_gambarplaylist" class="wadah">
                                                    <i class="fas fa-pen fa-2x"></i>
                                                </label>
                                                <input type="file" id="gambarplaylist" name="images"
                                                    accept="image/*" class="noob">
                                            </div>
                                        </div>
                                        <div class="col-md-7 ml-4">
                                            <div class="mb-3">
                                                <input type="text" class="form-control form-i" name="name"
                                                    id="nama" placeholder="Judul Playlist" maxlength="40">
                                            </div>
                                            <div class="mb-3">
                                                <textarea id="deskripsi" class="form-control" name="deskripsi" maxlength="200" rows="6" placeholder="Deskripsi"></textarea>
                                            </div>
                                        </div>
                                        <div class="text-md-right">
                                            <button class="btn" type="submit">Simpan</button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                    <script>
                        const gambarplaylist = document.querySelector("#gambarplaylist");

                        const tampilGambarplaylist = document.querySelector("#tampil_gambarplaylist");

                        gambarplaylist.addEventListener("change", function() {
                            const reader = new FileReader();

                            reader.addEventListener("load", () => {
                                tampilGambarplaylist.style.backgroundImage = `url(${reader.result})`;

                                tampilGambarplaylist.innerHTML = "";
                            });

                            reader.readAsDataURL(this.files[0]);
                        });
                    </script>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/pengguna/riwayat">
                        <span class="menu-icon">
                            <i class="mdi mdi-clock-outline"></i>
                        </span>
                        <span class="menu-title">Riwayat</span>
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
                                <button onclick="shuffle_song()" id="shuffle_button"><i class="fa fa-random"
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
                                        onchange="change_duration(this)">
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
                        <li class="nav-item w-75">
                            <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" method="POST"
                                action="{{ route('pencarian') }}">
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
                                        placeholder="cari di sini" value="" style="border-radius: 0px 15px 15px 0px">
                                </div>
                            </form>
                            <ul id="search-results"></ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
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
                                    <div class="profile-picture">
                                        <img class="img-xs rounded-circle" style="object-fit: cover;"
                                            src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                                    </div>
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name"
                                        style="width: 60px; overflow: hidden; text-overflow: ellipsis; height: 15px;">
                                        {{ auth()->user()->name }}</p>
                                </div>
                                <a href="{{ route('ubah.profile', auth()->user()->code) }}"
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
                                <a class="dropdown-item preview-item" href="{{ route('logout') }}">
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

            @include('sweetalert::alert')
            @yield('content')

            <script>
                $(document).ready(function() {
                    $('#search').on('keyup', function() {
                        var query = $(this).val();
                        $.ajax({
                            url: '/pengguna/search/',
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
                                        `<li><a href='/pengguna/search/${result.code}'>${result.judul}</a></li>`
                                    );
                                });
                                $.each(results.artists, function(index, result) {
                                    console.log(result.code);
                                    $searchResults.append(
                                        `<li><a href='/pengguna/search/${result.code}'>${result.name}</a></li>`
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
                                const artistId = item.artist_id;
                                const like = document.getElementById(`like-artist${item.artist_id}`);
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
                                const artistId = item.artist_id;
                            })
                            const count = document.getElementById('likeCount');
                            if (count) {
                                count.textContent = totalLikes;
                            }
                        },
                        error: function(response) {

                        }
                    })
                });

                function likeArtist(iconElement, artistId) {
                    const isLiked = iconElement.classList.contains('fas');
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
                    const likeIcons = document.querySelectorAll(`.like[data-id="${artistId}"]`);
                    likeIcons.forEach(likeIcon => {
                        likeIcon.classList.toggle('fas', isLiked);
                        likeIcon.classList.toggle('far', !isLiked);
                    });
                }
            </script>

            <script>
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $(document).ready(function() {
                    $.ajax({
                        url: `/song/check`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            // console.log(response);
                            response.forEach(function(item) {
                                const songId = item.song_id;
                                const like = document.getElementById(`like-1${item.song_id}`);
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
                            // console.log(response);
                            response.forEach(function(item) {
                                const songId = item.song_id;
                                const like = document.getElementById(`like-2${item.song_id}`);
                                if (like) {
                                    like.classList.toggle('fas');
                                }
                            })
                        }
                    });
                });


                function toggleLike(iconElement, songId) {
                    const isLiked = iconElement.classList.contains('fas');

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
                    const likeIcons = document.querySelectorAll(`.shared-icon-like[data-id="${songId}"]`);
                    likeIcons.forEach(likeIcon => {
                        likeIcon.classList.toggle('fas', isLiked);
                        likeIcon.classList.toggle('far', !isLiked);
                    });
                }
            </script>

            <script src="/assets/js/tablesort.js"></script>
            <script src="/user/assets/js/closepopup.js"></script>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
