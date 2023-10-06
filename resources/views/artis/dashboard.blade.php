@extends('artis.components.artisTemplate')

@section('content')
    <link rel="stylesheet" href="/user/assets/css/dashboard.css">
    @include('partials.tambahkeplaylist')


    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <h3 class="card-title mt-2 judul" style="font-size: 20px; font-weight: 600">Genre</h3>
                    <div class="cards">
                        @foreach ($genres as $item)
                            <a href="/artis/kategori/{{ $item->code }}" class="card cardi card-scroll rounded-4">
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
                                @foreach ($billboards->reverse() as $index => $item)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <a href="{{ route('detail.billboard', $item->code) }}" class="image-container">
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
                    <h3 class="card-title mt-2 judul" style="font-size: 20px; font-weight: 600">Lagu Terbaru</h3>
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
                                                        <a href="#lagu-diputar" class="flex-grow text-decoration-none link"
                                                            onclick="putaran({{ $item->id }})">
                                                            <h6 class="preview-subject">{{ $item->judul }}</h6>
                                                            <p class="text-muted mb-0" style="font-weight: 400">
                                                                {{ $item->artist->user->name }}</p>
                                                        </a>
                                                    </div>
                                                    <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                        <div class="text-group align-items-center">
                                                            <i id="like-atas{{ $item->id }}"
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
                <div class="col-md-5 stretch-card billboardheight">
                    <h3 class="card-title mb-4 judul" style="font-size: 20px; font-weight: 700">Artis Terbaru</h3>
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
                                                            width="10%" class="fotoartis">
                                                    </div>
                                                    <div
                                                        class="preview-item-content d-sm-flex flex-grow align-items-center">
                                                        <div class="flex-grow">
                                                            <h6 class="preview-subject"
                                                                onclick="redirectArtis('{{ $item->code }}')"
                                                                style="cursor: pointer">{{ $item->user->name }}</h6>
                                                            <p class="text-muted mb-0" style="font-weight: 400">
                                                                <span
                                                                    id="likeCount{{ $item->id }}">{{ number_format($item->likes, 0, ',', '.') }}</span>
                                                                suka
                                                            </p>
                                                        </div>
                                                        <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                            <i id="like-artist{{ $item->id }}"
                                                                data-id="{{ $item->id }}"
                                                                onclick="likeArtist(this, {{ $item->id }}, {{ $item->isLiked ? 'true' : 'false' }})"
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
                <div class="col-12 mb-5">
                    <h3 class="card-title mt-2 judul" style="font-size: 20px; font-weight: 600">Lagu Yang Sering Didengar
                    </h3>
                    <div class="bordertabel">
                        <table class="table">
                            <thead class="table-header headertext-ungu">
                                <tr class="header">
                                    <th scope="col" class="sortable" data-sort="asc">
                                        <i class="fas fa-caret-down ml-0"></i>
                                    </th>
                                    <th data-sort-col="judul"> Judul </th>
                                    <th data-sort-col="artist"> Didengar </th>
                                    <th data-sort-col="waktu"> Waktu </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($song as $no => $item)
                                    @if ($item->is_approved)
                                        <tr class="table-row baris" data-href="#lagu-diputar"
                                            onclick="putar({{ $item->id }})">
                                            <td class="table-cell" scope="row">{{ $no + 1 }}</td>
                                            <td class="table-cell">
                                                <div class="fototabelsejajar">
                                                    <img src="{{ asset('storage/' . $item->image) }}">
                                                    <div>
                                                        <a href="#lagu-diputar"
                                                            class="flex-grow text-decoration-none link"
                                                            onclick="putar({{ $item->id }})">
                                                            <h6 class="preview-subject">{{ $item->judul }}</h6>
                                                            <p class="text-muted mb-0">{{ $item->artist->user->name }}</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="table-cell">{{ number_format($item->didengar, 0, ',', '.') }}</td>
                                            <td class="table-cell"> <i id="like-bawah{{ $item->id }}"
                                                    data-id="{{ $item->id }}"
                                                    onclick="toggleLike(this, {{ $item->id }})"
                                                    class="shared-icon-like {{ $item->isLiked == '1' ? 'fas' : 'far' }} fa-heart pr-2"></i>
                                                {{ $item->waktu }}</td>
                                        </tr>
                                    @endIf
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <div class="text-center">
                            <ul class="pagination justify-content-center">
                                <!-- Pagination links will be dynamically generated here -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    {{-- like --}}
    <script>
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $(document).ready(function() {
            $.ajax({
                url: `/song/check`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('like atas', response);
                    response.forEach(function(item) {
                        let songId = item.song_id;
                        let like = document.getElementById(`like-atas${item.song_id}`);
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
                    console.log('like bawah', response);
                    response.forEach(function(item) {
                        let songId = item.song_id;
                        let like = document.getElementById(`like-bawah${item.song_id}`);
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
    </script>
    {{-- untuk header sortir --}}
    <script>
        $(document).ready(function() {
            var ascendingOrder = true; // Menyimpan status urutan saat ini

            $(".sortable").on("click", function() {
                // Mengubah urutan saat ini
                ascendingOrder = !ascendingOrder;

                // Mengubah ikon sesuai dengan urutan saat ini
                if (ascendingOrder) {
                    $(this).find("i").removeClass("fa-caret-up").addClass("fa-caret-down");
                } else {
                    $(this).find("i").removeClass("fa-caret-down").addClass("fa-caret-up");
                }

                // Memanggil fungsi untuk mengurutkan tabel
                sortTable(ascendingOrder);
            });

            function sortTable(ascending) {
                var rows = $(".table-row").toArray();

                rows.sort(function(a, b) {
                    var valA = parseInt($(a).find(".table-cell:first-child").text());
                    var valB = parseInt($(b).find(".table-cell:first-child").text());

                    if (ascending) {
                        return valA - valB;
                    } else {
                        return valB - valA;
                    }
                });

                // Mengganti urutan baris dalam tabel
                for (var i = 0; i < rows.length; i++) {
                    $(".table tbody").append(rows[i]);
                }
            }
        });
    </script>

    {{-- untuk paginate --}}
    <script>
        $(document).ready(function() {
            var itemsPerPage = 3;
            var ascendingOrder = true; // Menyimpan status urutan saat ini
            var currentPage = 1;

            // Fungsi untuk menyimpan halaman saat ini ke local storage
            function saveCurrentPageToLocalStorage(page) {
                localStorage.setItem("currentPage", page);
            }

            // Fungsi untuk mendapatkan halaman saat ini dari local storage
            function getCurrentPageFromLocalStorage() {
                return parseInt(localStorage.getItem("currentPage")) || 1;
            }

            // Mendapatkan halaman saat ini dari local storage atau default ke 1
            currentPage = getCurrentPageFromLocalStorage();

            function showTableRows() {
                var start = (currentPage - 1) * itemsPerPage;
                var end = start + itemsPerPage;

                // Mengambil semua baris tabel yang ada di tabel
                var rows = $(".baris").toArray();

                // Urutkan baris sesuai dengan urutan saat ini
                rows.sort(function(a, b) {
                    var valA = parseInt($(a).find(".table-cell:first-child").text());
                    var valB = parseInt($(b).find(".table-cell:first-child").text());

                    if (ascendingOrder) {
                        return valA - valB;
                    } else {
                        return valB - valA;
                    }
                });

                // Menyembunyikan semua baris tabel
                $(".baris").hide();

                // Menampilkan baris-baris yang sesuai dengan halaman saat ini
                for (var i = start; i < end && i < rows.length; i++) {
                    $(rows[i]).show();
                }
            }

            function updatePagination() {
                $(".pagination").empty();
                var numPages = Math.ceil($(".baris").length / itemsPerPage);

                var maxPaginationPages = 3; // Jumlah maksimum halaman pagination yang ditampilkan

                // Menentukan halaman pertama yang akan ditampilkan
                var startPage = Math.max(currentPage - Math.floor(maxPaginationPages / 2), 1);

                // Menentukan halaman terakhir yang akan ditampilkan
                var endPage = Math.min(startPage + maxPaginationPages - 1, numPages);

                // Tambahkan tombol "Previous" jika ada halaman sebelumnya
                if (currentPage > 1) {
                    var prevButton = $("<a>")
                        .addClass("page-item")
                        .addClass("page-link")
                        .attr("href", "#");

                    var prevIcon = $("<i>").addClass("fa fa-chevron-left");
                    prevButton.append(prevIcon);

                    prevButton.click(function(event) {
                        event.preventDefault(); // Menghentikan tindakan default
                        currentPage--;
                        showTableRows();
                        updatePagination();
                        saveCurrentPageToLocalStorage(currentPage);
                    });

                    $(".pagination").append($("<li>").append(prevButton));
                }

                for (var i = startPage; i <= endPage; i++) {
                    var activeClass = i === currentPage ? "active" : "";
                    var button = $("<a>")
                        .addClass("page-item " + activeClass)
                        .addClass("page-link")
                        .attr("href", "#");

                    button.text(i);

                    button.click(function(event) {
                        event.preventDefault(); // Menghentikan tindakan default
                        currentPage = parseInt($(this).text());
                        showTableRows();
                        updatePagination();
                        saveCurrentPageToLocalStorage(currentPage);
                    });

                    $(".pagination").append($("<li>").append(button));
                }

                // Tambahkan tombol "Next" jika ada lebih banyak halaman
                if (currentPage < numPages) {
                    var nextButton = $("<a>")
                        .addClass("page-item")
                        .addClass("page-link")
                        .attr("href", "#");

                    var nextIcon = $("<i>").addClass("fa fa-chevron-right");
                    nextButton.append(nextIcon);

                    nextButton.click(function(event) {
                        event.preventDefault(); // Menghentikan tindakan default
                        currentPage++;
                        showTableRows();
                        updatePagination();
                        saveCurrentPageToLocalStorage(currentPage);
                    });

                    $(".pagination").append($("<li>").append(nextButton));
                }

                if (numPages <= 1) {
                    $(".pagination").hide();
                }
            }

            $(".sortable").on("click", function() {
                ascendingOrder = !ascendingOrder;
                showTableRows();
                updatePagination();
                saveCurrentPageToLocalStorage(currentPage);
            });

            showTableRows();
            updatePagination();

            saveCurrentPageToLocalStorage(currentPage); // Simpan halaman saat ini ke local storage
        });
    </script>

    {{-- untuk href table --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const rows = document.querySelectorAll("tr[data-href]");

            rows.forEach(row => {
                row.addEventListener("click", () => {
                    window.location.href = row.dataset.href;
                })
            })
        });
    </script>

    {{-- lagu atas --}}
    {{-- <script>
        function redirectArtis(id) {
            $.ajax({
                url: `/artis/detail-artis/${id}`,
                type: 'GET',
                data: {
                    data: id
                },
                success: function(response) {
                    window.location.href = `/artis/detail-artis/${id}`;
                },
            });
        }

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
                    All_song = data.filter(lagu => lagu.is_approved === 1).map(lagu => {
                        return {
                            id: lagu.id,
                            judul: lagu.judul,
                            audio: lagu.audio,
                            image: lagu.image,
                            artistId: lagu.artist.user.name,
                        };
                    });
                    // untuk menurutkan lagu yang tampil pada browser :)
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

        function putaran(id) {
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
            if (index_no > 0) {
                index_no -= 1;
            } else {
                index_no = All_song.length - 1;
            }
            load_track(index_no);
            playsong();
        }

        // fungsi untuk memutar lagu sebelumnya
        function previous_song() {
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
    </script> --}}

    {{-- lagu bawah --}}
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

        function ambilDataLaguDidengar() {
            $.ajax({
                url: '/ambil-lagu',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    All_song = data.filter(lagu => lagu.is_approved === 1).map(lagu => {
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
                        load_track();
                    } else {
                        console.error("Data lagu kosong.");
                    }
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
        ambilDataLaguDidengar();

        function ambilDataLagu() {
            $.ajax({
                url: '/ambil-lagu',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    All_song = data.filter(lagu => lagu.didengar >= 1000).map(lagu => {
                        return {
                            id: lagu.id,
                            judul: lagu.judul,
                            audio: lagu.audio,
                            image: lagu.image,
                            artistId: lagu.artist.user.name,
                            didengar: lagu.didengar
                        };
                    });
                    All_song.sort((a, b) => b.didengar - a.didengar);
                    // untuk menurutkan lagu yang tampil pada browser :)
                    console.log("data lagu bawah:", All_song);

                    if (All_song.length > 0) {
                        // Memanggil load_track dengan indeks 0 sebagai lagu pertama
                        load_track();
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
                if (index_no >= 0 && index_no < All_song.length) {
                    track.play();
                    Playing_song = true;
                    play.innerHTML = '<i class="far fa-pause-circle fr" aria-hidden="true"></i>';
                } else {
                    console.log('Tidak ada lagu yang dipilih.');
                }
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

        function putaran(id) {
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
                    ambilDataLaguDidengar();
                } else {
                    index_no = 0; // Atur ke 0 jika lagu tidak ditemukan
                    load_track(index_no);
                    playsong();
                }
            } else {
                console.error('Lagu dengan ID ' + id + ' tidak ditemukan dalam data lagu.');
            }

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
                    ambilDataLagu();
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

    <script>
        function redirectArtis(id) {
            $.ajax({
                url: `/artis/detail-artis/${id}`,
                type: 'GET',
                data: {
                    data: id
                },
                success: function(response) {
                    window.location.href = `/artis/detail-artis/${id}`;
                },
            });
        }
    </script>
@endsection
