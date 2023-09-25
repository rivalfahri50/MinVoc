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
                    <h3 class="card-title mt-2 judul" style="font-size: 20px; font-weight: 600">Genre</h3>
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
                                        @foreach ($songs as $item)
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
                                                            <i id="like-1{{ $item->id }}"
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
                                        @foreach ($artist as $item)
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
                                                <i id="like-2{{ $item->id }}"
                                                    data-id="{{ $item->id }}"
                                                    onclick="toggleLike(this, {{ $item->id }})"
                                                    class="shared-icon-like {{ $item->isLiked ? 'fas' : 'far' }} fa-heart pr-2"></i>
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
        let slider_value = 0;


        let index_no = 0;
        let Playing_song = false;

        // create a audio element
        let track = document.createElement('audio');

        let All_song = [];

        async function ambilDataLagu() {
            await fetch('/ambil-lagu')
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
                    if (All_song.length > 0) {
                        // Memanggil load_track dengan indeks 0 sebagai lagu pertama
                        load_track(0);
                    } else {
                        console.error("Data lagu kosong.");
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
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
            let slider_value = slider.value;
            if (!isNaN(track.duration) && isFinite(slider_value)) {
                track.currentTime = track.duration * (slider_value / 100);
                console.log(track.duration * (slider_value / 100), slider_value, track.currentTime)

            }
        }

        slider.addEventListener('input', function() {
            slider_value = parseInt(slider_value);
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
