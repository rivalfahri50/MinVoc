@extends('artis.components.artisTemplate')


@section('content')
    <link rel="stylesheet" href="/user/assets/css/contohPlaylist.css">
    <link rel="stylesheet" href="/user/assets/css/buatPlaylist.css">
    @include('partials.tambahkeplaylist')
    <link rel="stylesheet" href="/user/assets/css/contohPlaylist.css">
    <style>
        .coba {
            width: 200px;
            height: 200px;
            position: relative;
            overflow: hidden;
            border: none;
            margin-right: 5px;

            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            border-radius: 10px;
            margin: 0;
            color: #957dad;
        }

        .coba:hover {
            background-color: #8452b5;
            color: #ffffff;
        }

        .cobai {
            width: 150px;
            height: 150px;
            position: relative;
            overflow: hidden;
            border: none;
            color: #957dad;
        }

        .cobai:hover {
            background-color: #69547d;
            color: #eaeaea;
        }

        .coba img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .custom-container {
            display: flex;
            flex-direction: column;
            position: relative;
            height: 100%;
        }

        .bottom-left-text {
            position: absolute;
            bottom: 0;
            left: 0;
            margin: 10px;
        }

        .img-and-text {
            display: flex;
            align-items: center;
        }

        .img-and-text img {
            margin-right: 10px;
        }

        .judulnottebal {
            margin: 0;
            display: flex;
            align-items: center;
        }

        .divider {
            border: none;
            border-top: 2px solid #6d6d6d;
            margin: 20px 0;
        }

        .scroll {
            position: relative;
            overflow-y: scroll;
            height: 50vh;
        }

        .scrollbar-down::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            border-radius: 10px;
        }

        .scrollbar-down::-webkit-scrollbar {
            width: 12px;
            background-color: #f5f5f5;
        }

        .scrollbar-down::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #957dad;
        }

        .thin::-webkit-scrollbar {
            width: 6px;
        }

        #tambahkeplaylist {
            width: 100%;
            height: 100%;
            position: fixed;
            background: rgba(0, 0, 0, 0.7);
            top: 0;
            left: 0;
            z-index: 9999;
            visibility: hidden;
        }

        #tambahkeplaylist .card-body {
            padding: 10px 7% 10px 7%;
        }

        /* Memunculkan Jendela Pop Up Detail*/
        #tambahkeplaylist:target {
            visibility: visible;
        }

        .windowi {
            background-color: #ffffff;
            width: 300px;
            border-radius: 10px;
            position: relative;
            margin: 15% auto;
            padding: 10px;
        }

        .close-button {
            display: block;
            color: #957dad;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .judul {
            font-size: 20px;
        }
    </style>
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
                            <div class="col-md-8 d-flex align-items-end">
                                <div class="card-body pb-0">
                                    <h3 class="my-1" style="font-weight: 600; font-size: 30px">{{ $playlistDetail->name }}
                                    </h3>
                                    <div style="display: flex; flex-direction: row; gap: 5px; align-items: center">
                                        <span>
                                            <img src="{{ asset('storage/' . $playlistDetail->user->avatar) }}"
                                                class="avatarpembuat">
                                        </span>
                                        <p class="m-0" style="font-weight: 300; font-size: 16px">
                                            {{ $playlistDetail->user->name }}
                                            @if ($playlistDetail->user->role_id == 1)
                                                <span class="mdi mdi-check-decagram text-primary verified-text"></span>
                                            @endif
                                        </p>
                                    </div>
                                    </p>
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
                <h3 class="card-title judul">Temukan berbagai lagu</h3>
                <form class="col-6 mb-4 p-0 nav-link search">
                    <input type="text" id="search_song" class="form-control rounded-4" placeholder="Cari musik">
                    <ul id="search-results-song"></ul>
                </form>
                <div class="card scroll scrollbar-down thin">
                    <div class="card-body">
                        <div class="row" style="margin-top: -20px">
                            <div class="col-12">
                                <div class="preview-list">
                                    @foreach ($songs as $item)
                                        @if ($item->is_approved)
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
            margin-right: 13px;
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
                                <textarea id="deskripsi" class="form-control" name="deskripsi" maxlength="500" rows="6"
                                    placeholder="{{ $playlistDetail->deskripsi == 'none' ? '' : $playlistDetail->deskripsi }}"></textarea>
                            </div>
                        </div>
                        <div class="text-md-right col-md-12">
                            <div class="button-container"> <!-- Add this container -->
                                <button class="btn btn-primary" type="submit">Ubah</button>
                                <button form="hapus" class="btn btn-delete" type="submit">Hapus</button>
                            </div>
                        </div>
                    </form>
                    <form id="hapus" action="{{ route('hapus.playlist.user', $playlistDetail->code) }}"
                        method="GET">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
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
        $(document).ready(function() {
            $('#search_song').on('keyup', function() {
                var query = $(this).val();
                var playlist_id = '{{ $playlistDetail->code }}'
                var id = $('#album_id').val()
                $.ajax({
                    url: `/artis/search_song/${playlist_id}`,
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
                                result.image + '" width="10%"></div>'
                            );

                            $previewItem.append(
                                `<div class="preview-item-content d-sm-flex flex-grow" href="#lagu-diputar" onclick="putar(${result.id})">
            <div class="flex-grow">
                <h6 class="preview-subject">${result.judul}</h6>
                <p class="text-muted mb-0">${result.artist.user.name}</p>
            </div>
            <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                <div class="text-group">
                    <i id="like-playlist-${result.id}" data-id="${result.id}" onclick="toggleLike(this, ${result.id})" class="shared-icon-like ${result.isLiked ? 'fas' : 'far'} fa-heart pr-2"></i>
                    <p>${result.waktu}</p>
                </div>
            </div>
        </div>`
                            );

                            $previewList.append($previewItem);
                        });

                    }
                });
            });
        });
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
        const playlistId = {{ $playlist_id }};
        let All_song = [];
        console.log("iki lhoooooooooooo", All_song);

        function ambilDataLagu(playlistId) {
            console.log('opo y', playlistId);
            $.ajax({
                url: '/ambil-lagu-playlist',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    All_song = data.map(lagu => {
                        return {
                            id: lagu.id,
                            judul: lagu.judul,
                            audio: lagu.audio,
                            image: lagu.image,
                            artistId: lagu.artist.user.name,
                            playlist_id: lagu.playlist_id,
                        };
                    });
                    All_song = All_song.filter(lagu => lagu.playlist_id == playlistId)
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

        ambilDataLagu(playlistId);

        // function load the track
        function load_track(index_no) {
            if (index_no >= 0 && index_no < All_song.length) {
                track.src = `https://drive.google.com/uc?export=view&id=${All_song[index_no].audio}`;
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
        // semua function

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
        // track.addEventListener('loadedmetadata', function() {
        //     slider.max = track.duration;
        // });


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
                // history(songId);
                console.log(All_song[index_no])
                updatePlayCount(songId);

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

        shuffleButton.addEventListener('click', function() {
            shuffle_song();
            console.log(shuffleButton);
        });


        function shuffle_song() {
            let currentIndex = All_song.length,
                randomIndex, temporaryValue;

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
            id = parseInt(id); // Pastikan id berupa bilangan bulat
            const lagu = All_song.find(song => song.id === id);
            console.log('lagu yang dikirim :', lagu);

            if (lagu) {
                const new_index_no = All_song.indexOf(lagu);
                if (new_index_no >= 0) {
                    index_no = new_index_no;
                    load_track(index_no);
                    playsong();
                } else {
                    index_no = 0; // Atur ke 0 jika lagu tidak ditemukan
                    load_track(index_no);
                    playsong();
                }
            } else {
                console.error('Lagu dengan ID ' + id + ' tidak ditemukan dalam data lagu.');
            }
        }

        track.addEventListener('ended', function() {
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
            let slider_value = slider.value;
            if (!isNaN(track.duration) && isFinite(slider_value)) {
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
            }
            if (track.ended) {
                play.innerHTML = '<i class="far fa-play-circle" aria-hidden="true"></i>';
                if (autoplay == 1) {
                    const songId = All_song[index_no].id;
                    history(songId);
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
@endsection
