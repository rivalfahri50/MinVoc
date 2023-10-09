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
                                                <div class="preview-item">
                                                    <div class="preview-thumbnail">
                                                        <img src="{{ asset('storage/' . $item->user->avatar) }}"
                                                            class="fotoartis">
                                                    </div>
                                                    <div class="preview-item-content d-sm-flex flex-grow">
                                                        <div
                                                            class="preview-item-content d-sm-flex flex-grow align-items-center">
                                                            <div class="flex-grow">
                                                                <h6 class="preview-subject"
                                                                    onclick="redirectArtis('{{ $item->code }}')"
                                                                    style="cursor: pointer">{{ $item->user->name }}
                                                                    @if ($item->is_verified)
                                                                        <span
                                                                            class="mdi mdi-check-decagram text-primary verified-text"></span>
                                                                    @endif
                                                                </h6>
                                                                <p class="text-muted mb-0">
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
                                                </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12" style="margin-bottom: 4rem;">
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
                                                            <h6 class="preview-subject" style="color: #4e4e4e;">
                                                                {{ $item->judul }}</h6>
                                                            <p class="text-muted mb-0" style="font-weight: 400">
                                                                {{ $item->artist->user->name }}</p>
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
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script>
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $(document).ready(function() {
            $.ajax({
                url: `/song/check`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
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
    <script>
        $(document).ready(function() {
            var ascendingOrder = true;

            $(".sortable").on("click", function() {
                ascendingOrder = !ascendingOrder;

                if (ascendingOrder) {
                    $(this).find("i").removeClass("fa-caret-up").addClass("fa-caret-down");
                } else {
                    $(this).find("i").removeClass("fa-caret-down").addClass("fa-caret-up");
                }

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

                for (var i = 0; i < rows.length; i++) {
                    $(".table tbody").append(rows[i]);
                }
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var itemsPerPage = 3;
            var ascendingOrder = true;
            var currentPage = 1;

            function saveCurrentPageToLocalStorage(page) {
                localStorage.setItem("currentPage", page);
            }

            function getCurrentPageFromLocalStorage() {
                return parseInt(localStorage.getItem("currentPage")) || 1;
            }

            currentPage = getCurrentPageFromLocalStorage();

            function showTableRows() {
                var start = (currentPage - 1) * itemsPerPage;
                var end = start + itemsPerPage;

                var rows = $(".baris").toArray();

                rows.sort(function(a, b) {
                    var valA = parseInt($(a).find(".table-cell:first-child").text());
                    var valB = parseInt($(b).find(".table-cell:first-child").text());

                    if (ascendingOrder) {
                        return valA - valB;
                    } else {
                        return valB - valA;
                    }
                });

                $(".baris").hide();

                for (var i = start; i < end && i < rows.length; i++) {
                    $(rows[i]).show();
                }
            }

            function updatePagination() {
                $(".pagination").empty();
                var numPages = Math.ceil($(".baris").length / itemsPerPage);

                var maxPaginationPages = 3;

                var startPage = Math.max(currentPage - Math.floor(maxPaginationPages / 2), 1);

                var endPage = Math.min(startPage + maxPaginationPages - 1, numPages);

                if (currentPage > 1) {
                    var prevButton = $("<a>")
                        .addClass("page-item")
                        .addClass("page-link")
                        .attr("href", "#");

                    var prevIcon = $("<i>").addClass("fa fa-chevron-left");
                    prevButton.append(prevIcon);

                    prevButton.click(function(event) {
                        event.preventDefault();
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
                        event.preventDefault();
                        currentPage = parseInt($(this).text());
                        showTableRows();
                        updatePagination();
                        saveCurrentPageToLocalStorage(currentPage);
                    });

                    $(".pagination").append($("<li>").append(button));
                }

                if (currentPage < numPages) {
                    var nextButton = $("<a>")
                        .addClass("page-item")
                        .addClass("page-link")
                        .attr("href", "#");

                    var nextIcon = $("<i>").addClass("fa fa-chevron-right");
                    nextButton.append(nextIcon);

                    nextButton.click(function(event) {
                        event.preventDefault();
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

            saveCurrentPageToLocalStorage(currentPage);
        });
    </script>

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
                    localStorage.setItem('All_song', JSON.stringify(All_song));
                    if (All_song.length > 0) {
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
                    localStorage.setItem('All_song_bawah', JSON.stringify(All_song));
                    if (All_song.length > 0) {
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

        function justplay() {
            if (Playing_song == false) {
                playsong();
            } else {
                pausesong();
            }
        }

        function reset_slider() {
            slider.value = 100;
        }

        function playsong() {
            if (track.paused) {
                if (index_no >= 0 && index_no < All_song.length) {
                    track.play();
                    Playing_song = true;
                    play.innerHTML = '<i class="far fa-pause-circle fr" aria-hidden="true"></i>';
                }
            } else {
                track.pause();
                Playing_song = false;
                play.innerHTML = '<i class="far fa-play-circle" aria-hidden="true"></i>';
            }

            if (index_no >= 0 && index_no < All_song.length) {
                const songId = All_song[index_no].id;
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
        }

        function history(songId) {
            $.ajax({
                url: '/simpan-riwayat',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    song_id: songId,
                },
            });
        }

        shuffleButton.addEventListener('click', function() {
            shuffle_song();
        });


        function shuffle_song() {
            let currentIndex = All_song.length,
                randomIndex, temporaryValue;

            while (currentIndex !== 0) {
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex--;
                temporaryValue = All_song[currentIndex];
                All_song[currentIndex] = All_song[randomIndex];
                All_song[randomIndex] = temporaryValue;
            }
            index_no = 0;
            load_track(index_no);
            playsong();
        }

        function pausesong() {
            track.pause();
            Playing_song = false;
            play.innerHTML = '<i class="far fa-play-circle" aria-hidden="true"></i>'
        }

        function putaran(id) {
            const storedAllSong = localStorage.getItem('All_song');
            if (storedAllSong) {
                All_song = JSON.parse(storedAllSong);
            }
            const lagu = All_song.find(song => song.id === id);

            if (lagu) {
                const new_index_no = All_song.indexOf(lagu);
                if (new_index_no >= 0) {
                    index_no = new_index_no;
                    load_track(index_no);
                    playsong();
                    ambilDataLaguDidengar();
                } else {
                    index_no = 0;
                    load_track(index_no);
                    playsong();
                }
            } else {
                console.error('Lagu dengan ID ' + id + ' tidak ditemukan dalam data lagu.');
            }

        }

        function putar(id) {
            const storedAllSong = localStorage.getItem('All_song_bawah');
            if (storedAllSong) {
                All_song = JSON.parse(storedAllSong);
            }
            const lagu = All_song.find(song => song.id === id);

            if (lagu) {
                const new_index_no = All_song.indexOf(lagu);
                if (new_index_no >= 0) {
                    index_no = new_index_no;
                    load_track(index_no);
                    playsong();
                    ambilDataLagu();
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
                setTimeout(function() {
                    track.play();
                }, 1000);
            }
        }

        function previous_song() {
            if (index_no > 0) {
                index_no -= 1;
            } else {
                index_no = All_song.length - 1;
            }
            load_track(index_no);
            playsong();
        }

        function volume_change() {
            volume_show.innerHTML = recent_volume.value;
            track.volume = recent_volume.value / 100;
        }

        function change_duration() {
            let slider_value = slider.value;
            if (!isNaN(track.duration) && isFinite(slider_value)) {
                track.currentTime = track.duration * (slider_value / 100);
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

        function range_slider() {
            let position = 0;
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

            const durationElement = document.getElementById('duration');
            const durationMinutes = Math.floor(track.duration / 60);
            const durationSeconds = Math.floor(track.duration % 60);
            const formattedDuration = `${durationMinutes}:${durationSeconds < 10 ? '0' : ''}${durationSeconds}`;
            durationElement.textContent = formattedDuration;
        }

        track.addEventListener('timeupdate', range_slider);

        if (track.ended) {
            play.innerHTML = '<i class="fa fa-play-circle" aria-hidden="true"></i>';
            if (autoplay == 1) {
                index_no += 1;
                load_track(index_no);
                playsong();
            }
        }

        function updateDuration() {
            const currentMinutes = Math.floor(track.currentTime / 60);
            const currentSeconds = Math.floor(track.currentTime % 60);
            const formattedCurrentTime = `${currentMinutes}:${currentSeconds < 10 ? '0' : ''}${currentSeconds}`;
            const currentTimeElement = document.getElementById('current-time');
            currentTimeElement.textContent = formattedCurrentTime;
        }

        function onTrackEnded() {
            track.removeEventListener('timeupdate', updateDuration);
        }

        muteButton.addEventListener('click', function() {
            mute_sound();
            updateMuteButtonIcon();
        });

        recent_volume.addEventListener('input', function() {
            let slider_value = recent_volume.value / 100;
            track.volume = slider_value;
            updateMuteButtonIcon();
            volume_show.innerHTML = Math.round(slider_value * 100);
        });

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
@endsection
