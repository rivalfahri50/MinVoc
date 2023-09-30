@extends('admin.components.adminTemplate')
@section('content')
    <link rel="stylesheet" href="/admin/assets/css/dashboard.css">
    <!-- partial | ISI -->
    <div class="main-panel">
        <style>
            .avatar {
                width: auto;
                /* Menghapus lebar tetap */
                height: 40px;
                /* Menentukan tinggi gambar */
                object-fit: cover;
                /* Memastikan gambar diisi sepenuhnya dan tidak melar */
                margin-right: 10px;
                border-radius: 0;
            }

            .small {
                font-size: .875em;
                vertical-align: 0.05357em;
                font-weight: 900;
            }
        </style>
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="row">
                        <div class="col-2">
                            <div class="card coba">
                                <h3 class="angka m-0">{{ $totalPengguna }} <span class="fas fa-user small ikon"></span></h3>
                                <h4 class="judul mb-3">Pengguna</h4>
                                <p class="teks">Sejak 2023</p>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="card coba">
                                <h3 class="angka m-0">{{ $totalLagu }}<span
                                        class="fas fa-microphone-alt small ikon"></span></h3>
                                <h4 class="judul mb-3">Lagu</h4>
                                <p class="teks">Sejak 2023</p>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="card coba">
                                <h3 class="angka m-0">{{ $totalArtist }} <span class="fas fa-music small ikon"></span></h3>
                                <h4 class="judul mb-3">Artis</h4>
                                <p class="teks">Sejak 2023</p>
                            </div>
                        </div>
                        <div class="col-6 row no-gutters">
                            <div class="card coba">
                                <img src="/assets/images/logo.svg" width="80%" height="100%" alt="logo"
                                    class="ml-5 md-3" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="card coba">
                        <canvas id="myChart" width="800" height="300"></canvas>
                    </div>
                </div>


                <div class="col-md-12">
                    <h3 class="judul">Riwayat Persetujuan </h3>
                    <div class="card mb-3">
                        <div class="table-body">
                            <div class="table-container">
                                <table class="table">
                                    <thead class="table-header">
                                        <tr class="table-row headerlengkung">
                                            <th class="table-cell">Judul Lagu</th>
                                            <th class="table-cell">Genre</th>
                                            <th class="table-cell">Tanggal Pengajuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $approvedCount = 0;
                                        @endphp
                                        @foreach ($songs->reverse() as $item)
                                            @if ($item->is_approved)
                                                <tr class="table-row baris">
                                                    <td class="table-cell">
                                                        <div class="cell-content">
                                                            <img src="{{ asset('storage/' . $item->image) }}" alt="Face"
                                                                class="avatar">
                                                            <div>
                                                                <h6>{{ $item->judul }}</h6>
                                                                <p class="text-muted m-0">{{ $item->artist->user->name }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="table-cell">{{ $item->genre->name }}</td>
                                                    <td class="table-cell">{{ $item->created_at->format('d F Y') }}</td>
                                                </tr>
                                                @php
                                                    $approvedCount++;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($approvedCount == 0)
                                            <table class="py-3">
                                                <span
                                                    style="display: flex; justify-content: center; margin-top: 14px; margin-bottom: 4px; font-size: 14px; color: #4f4f4f">
                                                    Tidak ada dalam history pencairan dana.
                                                </span>
                                            </table>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-center">
                            <ul class="pagination justify-content-center">
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Kode JavaScript untuk membuat grafik
        var ctx = document.getElementById('myChart').getContext('2d');
        var dataPendapatan = @json($totalPendapatan);

        var labels = Object.keys(dataPendapatan);
        var pendapatanBulanan = Object.values(dataPendapatan);
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                    'Oktober', 'November', 'Desember'
                ],
                datasets: [{
                    label: 'Pendapatan',
                    data: @json($month),
                    backgroundColor: [
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(153, 102, 255, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1,
                    barPercentage: 0.7,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            var itemsPerPage = 3;

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
@endsection
