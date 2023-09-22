<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="/admin/assets/css/style.css" />
    <link rel="stylesheet" href="{{ asset('style.css') }}" />
    <link rel="shortcut icon" href="/image/favicon.svg" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
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

        .sidebar .nav.sub-menu .nav-item .nav-link:hover {
            color: #7c6890;
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
        function confirmDelete(message, callback) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }

        function deleteGenre(code) {
            confirmDelete('Yakin menghapus Genre Lagu ini?', function() {
                window.location.href = '/admin/hapus-genre/' + code;
            });
        }

        function deleteSong(code) {
            confirmDelete('Yakin menghapus Lagu ini?', function() {
                window.location.href = '/admin/hapus-music/' + code;
            });
        }

        function deleteBillboard(code) {
            confirmDelete('Yakin menghapus Billboard ini?', function() {
                window.location.href = '/admin/hapus-billboard/' + code;
            });
        }
    </script>


</head>

<body>
    <div class="container-scroller">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="index.html"><img src="assets/images/logo.svg"
                        alt="logo" /></a>
            </div>
            <ul class="nav fixedbar">
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/admin/dashboard">
                        <span class="menu-icon ">
                            <i class="mdi mdi-home"></i>
                        </span>
                        <span class="menu-title">Beranda</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" data-toggle="collapse" href="#persetujuan" aria-expanded="false"
                        aria-controls="persetujuan">
                        <span class="menu-icon">
                            <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                        <span class="menu-title">Persetujuan</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="persetujuan">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/persetujuan">
                                    <span class="menu-icon mr-0">
                                        <i class="mdi mdi-check-circle-outline submenu" style="font-size: 20px;"></i>
                                    </span>Persetujuan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/pencairan">
                                    <span class="menu-icon mr-0">
                                        <i class="mdi mdi-check-circle-outline submenu" style="font-size: 20px;"></i>
                                    </span>Pencairan
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                        aria-controls="ui-basic">
                        <span class="menu-icon">
                            <i class="mdi mdi-format-list-bulleted-type"></i>
                        </span>
                        <span class="menu-title">Kategori</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/kategori">
                                    <span class="menu-icon mr-0">
                                        <i class="mdi mdi-plus-circle-outline submenu" style="font-size: 20px;"></i>
                                    </span>Genre
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/iklan">
                                    <span class="menu-icon mr-0">
                                        <i class="mdi mdi-plus-circle-outline submenu" style="font-size: 20px;"></i>
                                    </span>Papan Iklan
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/admin/verifikasi">
                        <span class="menu-icon">
                            <i class="mdi mdi-account-check-outline"></i>
                        </span>
                        <span class="menu-title">Verifikasi</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/admin/peraturan-bayar">
                        <span class="menu-icon">
                            {{-- <i class="mdi mdi-cog"></i> --}}
                            <i class="mdi mdi-cogs"></i>
                        </span>
                        <span class="menu-title">Pembayaran</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/admin/riwayat">
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
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle"
                                        src="https://cdn.pnghd.pics/data/815/profil-wa-kosong-28.jpg" alt="">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="profileDropdown">
                                <div class="p-3 mb-0 gap-3"
                                    style="display: flex; flex-direction: row; align-items: center;">
                                    <img class="img-xs rounded-circle"
                                        src="https://cdn.pnghd.pics/data/815/profil-wa-kosong-28.jpg" alt="">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name">Admin</p>
                                </div>
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
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

                function ambilDataLagu() {
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
                }

                ambilDataLagu();
                // semua function

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
                        const songId = All_song[index_no].id;
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

                            // Tambahkan ini untuk mencetak pesan kesalahan dari respons server
                            // console.log('Pesan Kesalahan Server:', xhr.responseText);
                        }
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

                // ubah posisi slider
                // Fungsi untuk mengubah posisi slider
                function change_duration() {
                    if (!isNaN(track.duration) && isFinite(slider_value)) {
                        let slider_value = parseInt(slider.value);
                        track.currentTime = track.duration * (slider_value / 100);
                        console.log(track.duration * (slider_value / 100), slider_value, track.currentTime)

                    }
                }

                slider.addEventListener('input', function() {
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
                        }
                    }

                    // kalkulasi waktu dari durasi audio
                    const durationElement = document.getElementById('duration');
                    const durationMinutes = Math.floor(track.duration / 60);
                    const durationSeconds = Math.floor(track.duration % 60);
                    const formattedDuration = `${durationMinutes}:${durationSeconds < 10 ? '0' : ''}${durationSeconds}`;
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
                    const currentMinutes = Math.floor(track.currentTime / 60);
                    const currentSeconds = Math.floor(track.currentTime % 60);
                    // Memformat durasi waktu yang akan ditampilkan
                    const formattedCurrentTime = `${currentMinutes}:${currentSeconds < 10 ? '0' : ''}${currentSeconds}`;
                    // console.log(formattedCurrentTime);
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

            <script src="assets/js/liked.js"></script>
            <script src="/user/assets/js/closepopup.js"></script>
            <!-- plugins:js -->
            <script src="assets/vendors/js/vendor.bundle.base.js"></script>
            <!-- endinject -->
            <!-- Plugin js for this page -->
            <script src="assets/vendors/chart.js/Chart.min.js"></script>
            <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
            <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
            <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
            <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
            <!-- End plugin js for this page -->
            <!-- inject:js -->
            <script src="assets/js/off-canvas.js"></script>
            <script src="assets/js/hoverable-collapse.js"></script>
            <script src="assets/js/misc.js"></script>
            <script src="assets/js/settings.js"></script>
            <script src="assets/js/todolist.js"></script>
            <!-- endinject -->
            <!-- Custom js for this page -->
            <script src="assets/js/dashboard.js"></script>
            <!-- End custom js for this page -->

</body>

</html>
