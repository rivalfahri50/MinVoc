@extends('admin.components.adminTemplate')

@foreach ($artist as $item)
    <div class="modal fade" id="staticBackdrop-{{ $item->code }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: whitesmoke;">
                <div class="modal-header" style="border-bottom: 0;">
                    <h3 class="modal-title judul" id="exampleModalLabel">Detail Pengajuan Verifikasi Akun</h3>
                    <button type="button" class="close-button far fa-times-circle" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 0 30px;">
                    <form action="{{ route('tambah.verified', $item->code) }}" method="post">
                        @csrf
                        <div class="row mt-4">
                            <div class="col-6 mb-4">
                                <div class="mb-4">
                                    <h5 class="judul mb-3">Nama :</h5>
                                    <td class="table-cell">
                                        <div class="cell-content">
                                            <img src="{{ asset('storage/' . $item->user->avatar) }}" alt="Face" class="avatar">
                                            <div>
                                                <p class="teksbiasa">{{ $item->user->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                </div>
                                <div class="mb-4">
                                    <h5 class="judul mb-3">Tanggal Pengajuan :</h5>
                                    <p class="teksbiasa">{{ $item->pengajuan_verified_at }}</p>
                                </div>
                                <div class="mb-4">
                                    <h5 class="judul mb-3">Pengikut :</h5>
                                    <p class="teksbiasa">{{ $item->Pengikut }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <h5 class="judul mb-3">Foto KTP :</h5>
                                <td class="table-cell">
                                    <div class="cell-content">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="Face" class="ktp">
                                    </div>
                                </td>
                            </div>
                        </div>
                        <div class="text-md-right">
                            <button type="submit" class="btn">Setujui</button>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modal1"
                                class="btn tolakbtn">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach


@section('content')
    @foreach ($artist as $item)
        {{-- @dd($item) --}}
        <div class="modal fade" id="modal1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color: whitesmoke;">
                    <div class="modal-header" style="border-bottom: 0;">
                        <h5 class="modal-title judul" id="exampleModalLabel">Alasan Menolak Persetujuan</h5>
                        <a href="" type="button" class="close-button far fa-times-circle"></a>
                    </div>
                    <div class="modal-body">
                        {{-- @dd($item) --}}
                        <form id="hapus" action="{{ route('hapus.verified', $item->code) }}" method="GET">
                            @csrf
                            <div class="form-group" style="margin-top: -20px">
                                <textarea class="form-control mt-3 " id="alasan" name="alasan" maxlength="200" rows="4"
                                    placeholder="Tulis alasan anda"></textarea>
                            </div>
                            <div class="text-md-right">
                                <button type="submit" class="btn">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <link rel="stylesheet" href="/admin/assets/css/verifikasi.css">
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

            .ktp {
                width: 100px;
                margin-right: 10px;
                border-radius: 0;
                height: 100px;
                object-fit: cover;
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

            /*---- style untuk jangka ----*/
            .card .card-body {
                padding: 5px 20px;
            }

            .tolakbtn {
                background-color: #fb101a;
                border: 1px solid #fb101a;
            }

            .tolakbtn:hover {
                color: #fb101a;
                border: 1px solid #fb101a;
                background-color: white !important;
            }

            button {
                border: none;
            }
        </style>
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="judul">Daftar Pengajuan Verifikasi Akun</h3>
                    <div class="card mb-3">
                        <div class="table-body">
                            <div class="table-container">
                                <table class="table">
                                    <thead class="table-header">
                                        <tr class="table-row headerlengkung">
                                            <th class="table-cell">Nama Pengguna</th>
                                            <th class="table-cell">Tanggal Pengajuan</th>
                                            <th class="table-cell">Status</th>
                                            <th class="table-cell">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($artist) > 0)
                                            @foreach ($artist as $item)
                                                @if ($item->pengajuan_verified_at)
                                                    <tr class="table-row ">
                                                        <td class="table-cell">
                                                            <div class="cell-content mt-1">
                                                                <img src="{{ asset('storage/' . $item->user->avatar) }}"
                                                                    alt="Face" class="avatar mt-1">
                                                                <div>
                                                                    <p>{{ $item->user->name }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="table-cell mt-1">{{ $item->pengajuan_verified_at }}
                                                        </td>
                                                        <td class="table-cell text-warning mt-1">
                                                            {{ $item->verification_status }}
                                                        </td>
                                                        <td class="table-cell">
                                                            <button type="button" class="btn btnicon mt-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#staticBackdrop-{{ $item->code }}">
                                                                <i class="far fa-eye text-info"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <div>
                                                <img width="100" src="/icon-notFound/adminIcon.svg" alt=""
                                                    srcset="">
                                            </div>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <div class="text-center">
                        <div class="text-center">
                            <ul class="pagination justify-content-center">
                                <!-- Item-item pagination akan ditambahkan secara dinamis menggunakan JavaScript -->
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



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            var itemsPerPage = 4;
            var currentPage = 1;

            function setURLParameter(page) {
                var newURL = window.location.href.split('?')[0] + '?page=' + page;
                window.history.replaceState({}, document.title, newURL);
            }

            function getURLParameter() {
                var urlParams = new URLSearchParams(window.location.search);
                return parseInt(urlParams.get('page')) || 1;
            }

            currentPage = getURLParameter();

            function showTableRows() {
                var start = (currentPage - 1) * itemsPerPage;
                var end = start + itemsPerPage;
                $(".baris").hide();
                $(".baris").slice(start, end).show();
            }

            function updatePagination() {
                $(".pagination").empty();
                var numPages = Math.ceil($(".baris").length / itemsPerPage);

                for (var i = 1; i <= numPages; i++) {
                    var activeClass = i === currentPage ? "active" : "";
                    var buttonText = i.toString();
                    var buttonClass = "page-link";
                    if (i === currentPage) {
                        buttonClass += " active";
                    }

                    var button = $("<a>")
                        .addClass("page-item " + activeClass)
                        .addClass(buttonClass)
                        .attr("href", "?page=" + i) // Set the page number as a query parameter
                        .text(buttonText);

                    $(".pagination").append($("<li>").append(button));
                }

                if (numPages <= 1) {
                    $(".pagination").hide();
                }
            }

            showTableRows();
            updatePagination();

            setURLParameter(currentPage);
        });
    </script>
@endsection
