@extends('artisVerified.components.artisVerifiedTemplate')

@section('content')
    <div class="main-panel">
        <link rel="stylesheet" href="/user/assets/css/riwayat.css">
        <style>
            i:hover {
                color: rebeccapurple;
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
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card" style="height: 100vh">
                    <div class="table-container" style="overflow-x: hidden">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <h3 class="judul fs-5">Riwayat Pencairan Penghasilan</h3>
                            </div>
                            <div class="col-md-8">
                                <form method="get" action="{{ route('filter.date.pencairan') }}"
                                    class="form-inline justify-content-end">
                                    <label class="mr-2">Cari Tanggal</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control mr-2"
                                        placeholder="Dari tanggal" value="{{ old('start_date') }}">
                                    <label class="mr-2">-</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control mr-2"
                                        placeholder="Sampai tanggal" value="{{ old('end_date') }}">
                                    <button type="submit" name="submit" class="btn">Cari</button>
                                </form>
                            </div>
                        </div>
                        <table class="table table-sortable" id="myTable">
                            <thead>
                                <tr class="table-row table-header">
                                    <th class="table-cell" data-sortable="true">Jumlah <i class="fas fa-sort"
                                            data-order="asc"></th>
                                    <th class="table-cell" data-sortable="true">Penghasilan <i class="fas fa-sort"
                                            data-order="asc"></th>
                                    <th class="table-cell" data-sortable="true">Tanggal <i class="fas fa-sort"
                                            data-order="asc"></th>
                                </tr>
                            </thead>
                            @if (session('results'))
                                @if (session('results'))
                                    <tbody>
                                        @foreach (session('results')->reverse() as $item)
                                            <tr class="table-row baris">
                                                <td class="table-cell">
                                                    <div class="cell-content">
                                                        <h6 class="text-success">Rp.
                                                            {{ number_format($item->penghasilanCair, 2, ',', '.') }}
                                                        </h6>
                                                    </div>
                                                </td>
                                                <td class="table-cell">{{ $item->status }}</td>
                                                <td class="table-cell">
                                                    {{ (new DateTime($item->Pengajuan_tanggal))->format('d F Y') }}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @else
                                    <table class="py-3">
                                        <div style="justify-content: center; display: flex; padding: 50px 0;">
                                            <img width="400" height="200" src="/user/assets/images/logo-user.svg"
                                                alt="" srcset="">
                                        </div>
                                    </table>
                                @endif
                            @else
                                @foreach ($penghasilan->reverse() as $item)
                                    <tr class="table-row baris">
                                        <td class="table-cell">
                                            <div class="cell-content">
                                                <h6 class="text-success">Rp.
                                                    {{ number_format($item->penghasilanCair, 2, ',', '.') }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td class="table-cell">{{ $item->status }}</td>
                                        <td class="table-cell">
                                            {{ (new DateTime($item->Pengajuan_tanggal))->format('d F Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>
                    @if (count($penghasilan) == 0)
                        <div style="justify-content: center; display: flex; padding: 50px 0;">
                            <img width="400" height="200" src="/user/assets/images/logo-user.svg" alt=""
                                srcset="">
                        </div>
                    @endif
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


    <script src="/user/assets/js/tablesort.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
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
@endsection
