@extends('admin.components.adminTemplate')
@section('content')
    <link rel="stylesheet" href="/admin/assets/css/persetujuan.css">
    <style>
        .over {
            width: 100px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <!-- partial | ISI -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="col-lg-12 grid-margin stretch-card">
                <h3 class="judul mb-4">Persetujuan Unggah Lagu</h3>
                <div class="table-container">
                    <table class="table table-sortable">
                        <thead class="table-header">
                            <tr class="table-row">
                                <th class="table-cell">Judul Lagu</th>
                                <th class="table-cell">Tanggal Pengajuan</th>
                                <th class="table-cell">Status</th>
                                <th class="table-cell">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($persetujuan->reverse() as $item)
                                @if (!$item->is_approved)
                                    <tr class="table-row baris">
                                        <td class="table-cell">
                                            <div class="cell-content">
                                                <img src="{{ asset('storage/' . $item->image) }}" alt="Face"
                                                    class="avatar">
                                                <div>
                                                    <h6 class="over">{{ $item->judul }}</h6>
                                                    <p class="text-muted m-0">{{ $item->artist->user->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="table-cell">{{ $item->created_at->format('d F Y') }}</td>
                                        <td class="table-cell text-warning">Pending</td>
                                        <td class="table-cell">
                                            <button type="button" class="btn btnicon" data-bs-toggle="modal"
                                                data-bs-target="#staticBackdrop-{{ $item->code }}">
                                                <i class="far fa-eye text-info"></i>
                                            </button>
                                            <button class="btn btnicon" onclick="deleteSong('{{ $item->code }}')">
                                                <i class="far fa-times-circle text-danger"></i>
                                            </button>
                                            <a href="#lagu-diputar" class="flex-grow text-decoration-none link btn"
                                                onclick="putar({{ $item->id }})">Putar Lagu</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if (count($persetujuan) === 0)
                    <div style="justify-content: center; display: flex; padding: 50px 0;">
                        <img width="400" height="200" src="/icon-notFound/adminIcon.svg" alt="" srcset="">
                    </div>
                @endif


                <div class="text-center">
                    <div class="text-center">
                        <ul class="pagination justify-content-center">
                            <!-- Item-item pagination akan ditambahkan secara dinamis menggunakan JavaScript -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- partial -->
    </div>

    <!-- popup -->
    @foreach ($persetujuan->reverse() as $item)
        <div class="modal fade" id="staticBackdrop-{{ $item->code }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('setuju.upload.music', $item->code) }}" method="get">
                    @csrf
                    <div class="modal-content" style="background-color: whitesmoke">
                        <div class="card-body">
                            <h3 class="judul">Persetujuan Unggah Lagu</h3>
                            <a href="" class="close-button far fa-times-circle"></a>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5 class="judul">Tanggal Pengajuan</h5>
                                    <p class="teksbiasa">
                                        {{ (new DateTime($item->created_at))->format('d F Y') }}
                                    </p>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <h5 class="judul">Judul Lagu</h5>
                                    <div class="cell-content">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="Face" class="avatar"
                                            style="width: 40px">
                                        <div>
                                            <h6>{{ $item->judul }}</h6>
                                            <p class="text-muted m-0">{{ $item->artist->user->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-md-right">
                                    <button class="btn" type="submit">Setujui</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    @endforeach
    </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.view-button').click(function() {
                // Dapatkan ID data dari tombol "Lihat" yang ditekan
                var itemId = $(this).data('id');

                // Dapatkan data yang sesuai dari tabel berdasarkan ID
                var itemData = <?php echo json_encode($persetujuan->toArray()); ?>.filter(function(item) {
                    return item.id === itemId;
                })[0];

                // Setel data ke dalam elemen-elemen di dalam pop-up
                $('#popup h3.judul').text('Persetujuan Unggah Lagu');
                $('#popup .teksbiasa').text(itemData.created_at);
                $('#popup h6').text(itemData.judul);
                $('#popup p.text-muted').text(itemData.artist.user.name);

                // Tampilkan pop-up
                $('#popup').show();
            });
            // Tambahkan fungsi untuk menutup pop-up saat tombol "Tutup" ditekan
            $('#popup .close-button').click(function() {
                $('#popup').hide();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var itemsPerPage = 4;

            // Fungsi untuk menyimpan halaman saat ini ke local storage
            function saveCurrentPageToLocalStorage(page) {
                localStorage.setItem("currentPage", page);
            }

            // Fungsi untuk mendapatkan halaman saat ini dari local storage
            function getCurrentPageFromLocalStorage() {
                return parseInt(localStorage.getItem("currentPage")) || 1;
            }

            // Mendapatkan halaman saat ini dari local storage atau default ke 1
            var currentPage = getCurrentPageFromLocalStorage();

            function showTableRows() {
                var start = (currentPage - 1) * itemsPerPage;
                var end = start + itemsPerPage;
                $(".baris").hide();
                $(".baris").slice(start, end).show();
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

            showTableRows();
            updatePagination();

            saveCurrentPageToLocalStorage(currentPage); // Simpan halaman saat ini ke local storage
        });
    </script>
    <script src="/user/assets/js/tablesort.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
