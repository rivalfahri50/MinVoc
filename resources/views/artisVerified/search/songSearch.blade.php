@extends('artisVerified.components.artisVerifiedTemplate')

@section('content')
    <link rel="stylesheet" href="/user/assets/css/songSearch.css">

    @include('partials.tambahkeplaylist')

    <style>
        .gayaputarlagu {
            font-size: 0.8rem;
            height: 1.5rem;
            line-height: 1px;
        }
    </style>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="row">
                        <div class="col-4">
                            <div class="card coba ukuran">
                                <div class="card-body" style="display: flex;">
                                    <div class="image-container">
                                        <img src="{{ asset('storage/' . $song->image) }}" alt="Face" class="avatar">
                                    </div>
                                    <div class="teks-container">
                                        <h4 class="judul clamp-text">
                                            {{ $song->judul }}</h4>
                                        <div class="d-flex flex-row align-content-center"
                                            style=" display: flex; flex-direction: row; align-items: center">
                                            <p class="text-muted m-1 clamp-text" style="font-size: 16px">
                                                {{ $song->artist->user->name }}</p>
                                                <a href="#lagu-diputar" class="flex-grow text-decoration-none link"
                                                onclick="putar({{ $song->id }})">
                                                <button type="button" class="btn gayaputarlagu">
                                                    Putar Lagu
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr class="divider"> <!-- Divider -->
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <h3 class="card-title judul">Lagu-lagu</h3>
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
                                                    <a href="#lagu-diputar" class="flex-grow text-decoration-none link"
                                                        onclick="putar({{ $item->id }})">
                                                        <h6 class="preview-subject">{{ $item->judul }}</h6>
                                                        <p class="text-muted mb-0">{{ $item->artist->user->name }}</p>
                                                    </a>
                                                    <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                        <div class="text-group">
                                                            <i id="like{{ $item->id }}" data-id="{{ $item->id }}"
                                                                onclick="toggleLike(this, {{ $item->id }})"
                                                                class="shared-icon-like {{ $item->isLiked ? 'fas' : 'far' }} fa-heart pr-2"></i>
                                                            </i>
                                                            <p>{{ $item->waktu }}</p>
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
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <script>
            // function togglePlayPause() {
            //     const playIcon = document.getElementById('playIcon');

            //     if (isPlaying) {
            //         // Jika sedang diputar, ganti menjadi pause
            //         playIcon.classList.remove('fa-pause-circle');
            //         playIcon.classList.add('fa-play-circle');
            //     } else {
            //         // Jika sedang tidak diputar, ganti menjadi play
            //         playIcon.classList.remove('fa-play-circle');
            //         playIcon.classList.add('fa-pause-circle');
            //     }

            //     // Ubah status pemutaran
            //     isPlaying = !isPlaying;

            //     // Panggil fungsi justplay() jika diperlukan
            //     justplay();
            // }
        </script>
    </div>

    <script>
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

        ambilDataLagu();

        // function load the track
        function load_track(index_no) {
            if (index_no >= 0 && index_no < All_song.length) {
                console.log("tester " + index_no);
                track.src = `https://drive.google.com/uc?export=view&id=${All_song[index_no].audio}`;
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
            let slider_value = slider.value;
            if (!isNaN(track.duration) && isFinite(slider_value)) {
                track.currentTime = track.duration * (slider_value / 100);
                console.log(track.duration * (slider_value / 100), slider_value, track.currentTime)
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
    </script>
@endSection
