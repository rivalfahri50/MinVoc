@extends('artisVerified.components.artisVerifiedTemplate')

@section('content')
    <link rel="stylesheet" href="/admin/assets/css/dashboard.css">
    <!-- partial | ISI -->
    <div class="main-panel">
        <style>
            .table-container {
                margin-bottom: 20px;
            }

            .table-sortable th {
                cursor: pointer;
                border-radius: 10px;
            }

            .table-sortable .th-sort-asc::after {
                content: "\25b4";
            }

            .table-sortable .th-sort-desc::after {
                content: "\25be";
            }

            .table-sortable .th-sort-asc::after,
            .table-sortable .th-sort-desc::after {
                margin-left: 10px;
            }

            /*---- style untuk table ----*/
            .table-body {
                padding: 20px;
            }


            .table-container {
                max-width: 100%;
                overflow-x: auto;
            }

            .table {
                width: 100%;
                border-spacing: 0;
            }

            .header {
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
                padding-top: 10px;
                padding-bottom: 10px;
                color: white;
            }

            .avatar {
                width: 40px;
                margin-right: 10px;
            }

            .table td img {
                border-radius: 0;
            }

            .cell-content {
                display: flex;
                align-items: center;
            }

            .table-cell h6,
            .table-cell p {
                margin: 0;
                padding: 5px 0;
            }

            .table-container {
                margin-bottom: 20px;
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

            .judul {
                padding: 5px;
                color: #957DAD;
                font-weight: 600;
                font-size: 20px;
            }

            .jarak {
                gap: 5px;
            }

            .pcard {
                padding: 15px 10px;
                height: 100%
            }

            .link {
                color: #85BAD9;
                border: none;
                background: none;
                text-align: left;
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
                <div class="col-md-12 mb-3">
                    <div class="row">
                        <div class="col-4">
                            <div class="card pcard jarak">
                                <h3 class="angka m-0">Rp {{ number_format($totalpenghasilan, 2, ',', '.') }}</h3>
                                <h4 class="judulnottebal mb-0">Total penghasilan</h4>
                                @if ($totalpenghasilan > 0)
                                    @if (isset($penghasilanData->Pengajuan))
                                        <span class="btn-unstyled mr-2 link mb-0" style="cursor: pointer"
                                            data-bs-toggle="modal" data-bs-target="#caripenghasilan">Cairkan
                                            Penghasilan</span>
                                    @else
                                        <span class="btn-unstyled mr-2 link mb-0">Mohon tunggu jawaban dari admin..</span>
                                    @endif
                                @endif
                                @if (isset($penghasilanData->is_submit) && $penghasilanData->is_submit && $penghasilanData->penghasilanCair)
                                    <span style="color: #858585">Terakhir diambil pada
                                        {{ (new DateTime($penghasilanData->terakhir_diambil))->format('d F Y') }}</span>
                                @endif
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
                                    <form action="{{ route('pencairan.artiVerified', auth()->user()->id) }}" method="post">
                                        @csrf
                                        <div class="modal-body border-0">
                                            <div class="col-md-12" style="font-size: 13px;">
                                                <div class="mb-3 pcard jarak" style="height: 100%;">
                                                    <p for="namakategori" class="form-label judulnottebal">Total Penghasilan
                                                    </p>
                                                    <h3 class="judul">Rp
                                                        {{ number_format($totalpenghasilan, 2, ',', '.') }}
                                                    </h3>
                                                </div>
                                                <div class="mb-3">
                                                    <p for="konsep" class="form-label judulnottebal">Jumlah Pencairan</p>
                                                    <input type="text" id="harga_pencairan" class="form-control"
                                                        name="pencairan" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" class="btn rounded-3">
                                                <a class="btn-link"
                                                    style="color: inherit; text-decoration: none;">Setujui</a></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-8 row no-gutters">
                            <div class="card px-3">
                                <h3 class="judul" style="font-weight: 500; margin-left: -6px">Informasi</h3>
                                <p class="judulnottebal fs-6">Hi, {{ auth()->user()->name }}!
                                    Anda sebagai artis ter verifikasi penghasilan dalam MusiCave didapatkan dari jumlah
                                    pendengar musik, unggah lagu, dan kolaborasi bersama artis ter verifikasi lainnya.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <h3 class="judul">Grafik total penghasilan</h3>
                    <div class="card coba">
                        <canvas id="myChart" width="800" height="300"></canvas>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <h3 class="judul" style="font-size: 18px">Riwayat Penghasilan Masuk</h3>
                        </div>
                        <div class="col-md-8">
                            <form method="get" action="{{ route('filter.date') }}"
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
                    <div class="card mb-3">
                        <div class="table-body">
                            <div class="table-container">
                                <table class="table">
                                    <thead class="table-header">
                                        <tr class="table-row header headerlengkung">
                                            <th class="table-cell">Jumlah</th>
                                            <th class="table-cell">Penghasilan</th>
                                            <th class="table-cell">Tanggal</th>
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
                                                                    {{ number_format($item->penghasilan, 2, ',', '.') }}
                                                                </h6>
                                                            </div>
                                                        </td>
                                                        <td class="table-cell">{{ $item->status }}</td>
                                                        <td class="table-cell">
                                                            {{ $item->created_at->format('j F Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @else
                                            <table class="py-3">
                                                <span
                                                style="display: flex; justify-content: center; margin-top: 14px; margin-bottom: 4px; font-size: 14px; color: #4f4f4f">
                                                Tidak ada dalam history pencairan dana.
                                            </span>
                                            </table>
                                        @endif
                                    @else
                                        @if (count($penghasilanArtis) >= 1)
                                            <tbody>
                                                @foreach ($penghasilanArtis->reverse() as $item)
                                                    <tr class="table-row baris">
                                                        <td class="table-cell">
                                                            <div class="cell-content">
                                                                <h6 class="text-success">Rp.
                                                                    {{ number_format($item->penghasilan, 2, ',', '.') }}
                                                                </h6>
                                                            </div>
                                                        </td>
                                                        <td class="table-cell">{{ $item->status }}</td>
                                                        <td class="table-cell">{{ $item->created_at->format('j F Y') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @else
                                            <table>
                                                <span
                                                    style="display: flex; justify-content: center; margin-top: 14px; margin-bottom: 4px; font-size: 14px; color: #4f4f4f">
                                                    Tidak ada dalam history pencairan dana.
                                                </span>
                                            </table>
                                        @endif
                                    @endif
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
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/user/assets/js/tablesort.js"></script>

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
    <script>
        const code = "{{ auth()->user()->code }}"
        fetch(`/artis-verified/pencairan/${code}`)
            .then(response => response.json())
            .then(data => {
                const inputElement = document.getElementById('harga_pencairan');

                inputElement.value = data.total_penghasilan;

                const event = new Event('input', {
                    bubbles: true
                });
                inputElement.dispatchEvent(event);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });

        /* ============Dengan Rupiah=========== */
        var harga = document.getElementById('harga');
        harga.addEventListener('keyup', function(e) {
            harga.value = formatRupiah(this.value, 'Rp. ');
        });

        /* Fungsi */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var dataPendapatan = @json($penghasilan);

        var labels = Object.keys(dataPendapatan);
        console.log(labels);
        var pendapatanBulanan = Object.values(dataPendapatan);
        console.log(pendapatanBulanan);
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'mei', 'juni', 'Juli', 'Agustus', 'september',
                    'oktober', 'november', 'desember'
                ],
                datasets: [{
                    label: 'Pendapatan',
                    data: @json($month),
                    backgroundColor: [
                        'rgba(153, 102, 255, 2)',
                        'rgba(153, 102, 255, 2)',
                        'rgba(153, 102, 255, 2)',
                        'rgba(153, 102, 255, 2)',
                        'rgba(153, 102, 255, 2)'
                    ],
                    borderColor: [
                        'rgba(153, 102, 255, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1,
                    barPercentage: 0.7
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

@endsection
