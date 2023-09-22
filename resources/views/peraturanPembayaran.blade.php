@extends('admin.components.adminTemplate')



@section('content')
    <link rel="stylesheet" href="/admin/assets/css/verifikasi.css">
    <!-- partial | ISI -->
    <div class="main-panel">
        <style>
            .table-container {
                margin-bottom: 20px;
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

            button {
                border: none;
                background: none;
            }

            .styleinput {
                background-color: white;
                border: 1px solid #dfdfdf;
            }

            .styleinput:hover {
                background-color: white;
                border: 1px solid #957DAD;
            }

            .styleinput:focus {
                background-color: white;
                border: 1px solid #957DAD;
            }

            .form-control::placeholder {
                color: #c0c0c0;
            }
        </style>
        @php
            $selectedOptions = [];
            foreach ($tipePembayaran as $item) {
                $selectedOptions[] = $item->opsi->id;
            }
        @endphp
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="judul">Atur Pembayaran</h3>
                    {{-- <span style="font-size: 14px; margin-bottom: 10px">
                        Di Musicave, kami menerapkan aturan pembayaran yang adil untuk kolaborasi. Riwayat musik Anda adalah
                        kumpulan perjalanan musikal Anda yang memukau. Dan yang terbaik, Anda dapat dengan mudah mengunggah
                        karya musik orisinal Anda untuk menciptakan hubungan yang lebih dalam dengan para penggemar Anda.
                    </span> --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <form action="{{ route('peraturan') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-4 mb-3">
                                        <label for="tipe" class="form-label judulnottebal">Tipe pembayaran </label>
                                        <select required name="opsi" required class="form-select" id="tipe">
                                            @foreach ($opsi as $option)
                                                @if (in_array($option->id, $selectedOptions))
                                                    <option value="{{ $option->id }}" disabled>{{ $option->tipe }} (Sudah
                                                        dibuat)</option>
                                                @else
                                                    <option value="{{ $option->id }}">{{ $option->tipe }}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                        @error('opsi')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="namakategori" class="form-label judulnottebal">Pendapatan Artis</label>
                                        <input type="number" class="form-control styleinput" name="pembayaranArtis"
                                            id="harga1" min="10000" minlength="5" maxlength="6" required
                                            placeholder="10000">
                                        @error('pembayaranArtis')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4 mb-4">
                                        <label for="namakategori" class="form-label judulnottebal">Komisi Admin</label>
                                        <input type="number" name="pembayaranAdmin" class="form-control form-i styleinput"
                                            id="harga2" min="10000" minlength="5" maxlength="6" required
                                            placeholder="10000">
                                        @error('pembayaranAdmin')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text-md-right">
                                    <button type="submit" class="btn rounded-3" style="width: 32%">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <h3 class="judul">Pengaturan Pembayaran</h3>
                    <div class="card mb-3">
                        <div class="table-body">
                            <div class="table-container">
                                <table class="table">
                                    <thead class="table-header">
                                        <tr class="table-row header headerlengkung">
                                            <th class="table-cell">Tipe Pembayaran</th>
                                            <th class="table-cell">Jumlah</th>
                                            <th class="table-cell">Tanggal</th>
                                            <th class="table-cell">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tipePembayaran as $item)
                                            <tr class="table-row baris">
                                                <td class="table-cell">
                                                    {{ $item->opsi->tipe }}
                                                </td>
                                                <td class="table-cell">
                                                    Rp. {{ number_format($item->pendapatanArtis, 2, ',', '.') }}
                                                </td>
                                                <td class="table-cell">
                                                    Rp. {{ number_format($item->pendapatanAdmin, 2, ',', '.') }}
                                                </td>
                                                <td class="table-cell">
                                                    <button type="button" class="btn btnicon" data-bs-toggle="modal"
                                                        data-bs-target="#detail-{{ $item->code }}">
                                                        <i class="far fa-eye text-info"></i>
                                                    </button>
                                                    <button type="button" class="btn btnicon edit-button"
                                                        data-bs-toggle="modal" data-id="{{ $item->code }}" id="edit"
                                                        data-bs-target="#edit-{{ $item->code }}">
                                                        <i class="far fa-edit text-primary"></i>
                                                    </button>
                                                    {{-- <button class="btn btnicon confirmButtonReject" type="submit"> --}}
                                                    <a class="btn btnicon confirmButtonReject"
                                                        href="/admin/delete-pencairan/{{ $item->code }}">
                                                        <i class="far fa-times-circle text-danger"></i>
                                                    </a>
                                                    {{-- <form method="GET"
                                                            action="/admin/pencairan-reject/{{ $item->id }}">
                                                            @csrf --}}
                                                    {{-- </form> --}}
                                                    {{-- </button> --}}
                                                </td>
                                            </tr>
                                        @endforeach
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
            </div>
        </div>
        <!-- partial -->
    </div>
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    @foreach ($tipePembayaran as $item)
        <div class="modal fade" id="detail-{{ $item->code }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color: whitesmoke;">
                    <div class="modal-header" style="border-bottom: 0;">
                        <h3 class="modal-title judul" id="exampleModalLabel">Detail pengaturan pembayaran</h3>
                        <button type="button" class="close-button far fa-times-circle" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body mb-4" style="padding: 0 30px;">
                        <div class="mb-3">
                            <label for="namakategori" class="form-label judulnottebal">Tipe Pembayaran</label>
                            <input type="text" name="name" class="form-control form-i" id="namaproyek"
                                value="{{ $item->opsi->tipe }}" readonly disabled>
                        </div>
                        <div class="mb-3">
                            <label for="namakategori" class="form-label judulnottebal">Jumlah</label>
                            <input type="text" name="name" class="form-control form-i" id="namaproyek"
                                value="Rp. {{ number_format($item->pendapatanAdmin, 2, ',', '.') }}" readonly disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($tipePembayaran as $item)
        <div class="modal fade" id="edit-{{ $item->code }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color: whitesmoke;">
                    <form action="{{ route('update.pendapatan', $item->code) }}" method="post">
                        @csrf
                        <div class="modal-header" style="border-bottom: 0;">
                            <h3 class="modal-title judul" id="exampleModalLabel">Edit pengaturan pembayaran</h3>
                            <button type="button" class="close-button far fa-times-circle" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body mb-4" style="padding: 0 30px;">
                            <div class="mb-3">
                                <label for="ops" class="form-label judulnottebal">Tipe pendapatan</label>
                                <input type="text" name="opsi" class="form-control form-i" id="ops" required
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label for="pendapatan1" class="form-label judulnottebal">Pendapatan Artis</label>
                                <input type="number" name="pembayaranArtis" class="form-control form-i"
                                    id="pendapatan1" required>
                            </div>
                            <div class="mb-3">
                                <label for="pendapatan2" class="form-label judulnottebal">Pendapatan Admin</label>
                                <input type="number" name="pembayaranAdmin" class="form-control form-i"
                                    id="pendapatan2" required>
                            </div>
                            <div class="text-md-right">
                                <button type="submit" class="btn">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[type="number"]').on('input', function() {
                var maxDigits = 6; // Set the maximum number of digits allowed

                if ($(this).val().length > maxDigits) {
                    $(this).val($(this).val().slice(0, maxDigits));
                }
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
    <script>
        $(document).on('click', '.edit-button', function() {
            const itemId = $(this).data('id');

            fetch(`/admin/items/${itemId}`)
                .then(response => response.json())
                .then(data => {
                    const editModal = document.getElementById('edit-' + itemId);
                    const tipeInput = editModal.querySelector('#ops');
                    const jumlahInput1 = editModal.querySelector('#pendapatan1');
                    const jumlahInput2 = editModal.querySelector('#pendapatan2');

                    tipeInput.value = data.data.opsi.tipe;
                    jumlahInput1.value = data.data.pendapatanArtis;
                    jumlahInput2.value = data.data.pendapatanAdmin;
                })
                .catch(error => {
                    console.error('Error fetching item data:', error);
                });
        });
    </script>
@endsection
