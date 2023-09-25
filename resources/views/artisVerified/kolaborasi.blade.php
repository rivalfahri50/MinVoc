@extends('artisVerified.components.artisVerifiedTemplate')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="main-panel">
        <style>
            .modal-content {
                position: relative;
                display: flex;
                flex-direction: column;
                width: 100%;
                pointer-events: auto;
                background-color: white background-clip: padding-box;
                border: none;
                border-radius: 1rem;
                outline: 0;
            }

            button {
                border: none;
                background: none;
            }

            /*---- style untuk table ----*/
            .table-container {
                max-height: 200px;
                overflow-y: auto;
                position: relative;
                margin-bottom: 20px;
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

            /* Style for the fixed header */
            .fixed-header {
                position: sticky;
                top: 0;
                z-index: 1;
                background-color: #f3f3f3;
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

            /*---- style untuk jangka ----*/
            .card .card-body {
                padding: 5px 20px;
            }

            /* Style tombol sejajar */
            .sejajar {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
            }

            #tambahkategori {
                width: 100%;
                height: 100%;
                position: fixed;
                background: rgba(0, 0, 0, 0.7);
                top: 0;
                left: 0;
                z-index: 9999;
                visibility: hidden;
            }

            #tambahkategori .card-body {
                padding: 10px 7% 10px 7%;
            }

            /* Memunculkan Jendela Pop Up*/
            #tambahkategori:target {
                visibility: visible;
            }

            .window {
                background-color: #ffffff;
                width: 500px;
                border-radius: 10px;
                position: relative;
                margin: 7% auto;
                padding: 10px;
            }

            .close-button {
                display: block;
                color: #957dad;
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 15px;
            }

            .chat-box {
                overflow-y: scroll;
                height: 29vh;
                background-color: #eaeaea;
                border-radius: 10px;
                /* border: 1px solid rgba(0, 0, 0, 0.2); */
                padding: 10px;
            }

            /* CSS untuk pesan chat */
            .chat-message {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 10px;
            }

            .chat-name {
                font-size: 12px;
                color: rgb(171, 171, 171);
                text-align: right;
            }

            .chat-text {
                font-size: 14px;
                color: rgb(52, 52, 52);
                background-color: whitesmoke;
                max-width: 50%;
                border-radius: 15px;
                padding: 8px 15px;
            }

            /* CSS untuk input chat */
            .chat-input {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 10px;
                padding: 10px;
                display: flex;
                align-items: center;
            }

            .send-button {
                background-color: #957dad;
                color: #fff;
                border: none;
                padding: 5px 10px;
                border-radius: 4px;
                cursor: pointer;
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

            .judul {
                padding: 5px;
                color: #957DAD;
                font-weight: 600;
                font-size: 20px;
            }

            .flex-grow.text-decoration-none.link.btn {
                max-width: 100px;
                /* Ganti dengan lebar maksimum yang Anda inginkan */
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const confirmButtons = document.querySelectorAll('.confirmButton');

                confirmButtons.forEach(confirmButton => {
                    confirmButton.addEventListener('click', function(event) {
                        event.preventDefault(); // Mencegah pengiriman formulir langsung

                        const itemCode = this.getAttribute('data-item-code');
                        const tableRow = this.closest(
                            'tr'); // Mendapatkan baris tabel yang berisi tombol hapus

                        Swal.fire({
                            title: 'Konfirmasi Hapus',
                            text: 'Apakah Anda yakin ingin menghapus project ini?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Jika pengguna mengonfirmasi, kirimkan formulir
                                const form = event.target.closest('form');
                                if (form) {
                                    form.submit();
                                }
                            }
                        });

                    });
                });
            });


            document.addEventListener('DOMContentLoaded', function() {
                const confirmButtonRejects = document.querySelectorAll('.confirmButtonReject');

                confirmButtonRejects.forEach(confirmButtonReject => {

                    confirmButtonReject.addEventListener('click', function(event) {
                        event.preventDefault(); // Mencegah pengiriman formulir langsung
                        const itemCode = this.getAttribute('data-item');
                        const tableRow = this.closest('tr');
                        Swal.fire({
                            title: 'Konfirmasi Hapus',
                            text: 'Apakah Anda yakin ingin menolak kolaborasi ini?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Jika pengguna mengonfirmasi, kirimkan formulir
                                const form = event.target.closest('form');
                                if (form) {
                                    form.submit();
                                }
                            }
                        });
                    });
                });
            });
        </script>


        <div class="content-wrapper">
            <div class="row ">
                <div class="col-12 grid-margin">
                    <div class="sejajar">
                        <h3 style="color: #957DAD">Kolaborasi</h3>
                        <div class="text-lg-end mb-3">
                            <button class="btn full-width-btn" type="button" data-bs-toggle="modal"
                                data-bs-target="#tambahModal">
                                <i class="fas fa-plus"></i>
                                Tambah kolaborasi
                            </button>
                        </div>
                    </div>
                    <div class="card rounded-4">
                        <div class="card-body pt-3">
                            <div class="table-container scrollbar-down thin">
                                <table class="table custom-table" style="">
                                    <thead class="table-header fixed-header">
                                        <tr class="table-row header headerlengkung">
                                            <th class="table-cell"> Nama Proyek </th>
                                            <th class="table-cell"> Tanggal </th>
                                            <th class="table-cell"> Aksi </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas->reverse() as $item)
                                            @if ($item->artist_id === $artisUser->id)
                                                @if (
                                                    !$item->is_reject &&
                                                        $item->judul == 'none' &&
                                                        $item->audio == 'none' &&
                                                        $item->request_project_artis_id_1 == null &&
                                                        $item->request_project_artis_id_2 == null)
                                                    <tr class="table-row">
                                                        <td class="table-cell">
                                                            <span class="pl-2">{{ $item->name }}</span>
                                                        </td>
                                                        <td class="table-cell">{{ $item->created_at->format('d F Y') }}</td>
                                                        <td class="d-flex align-items-center">
                                                            <a href="" class="btn-unstyled" data-bs-toggle="modal"
                                                                data-bs-target="#staticBackdrop-{{ $item->code }}">
                                                                <i class="mdi mdi-eye btn-icon text-primary"
                                                                    style="font-size: 20px; margin-right: 2px;"></i>
                                                            </a>

                                                            <button type="button" class="confirmButton"
                                                                data-item-code="{{ $item->code }}">
                                                                <form action="{{ route('reject.project.artisVerified') }}"
                                                                    method="post" class="m-0">
                                                                    @csrf
                                                                    <input type="hidden" name="code"
                                                                        value="{{ $item->code }}">
                                                                    <input type="hidden" name="is_reject" value="true">
                                                                    <i class="mdi mdi-close-circle-outline btn-icon text-danger"
                                                                        style="font-size: 20px"></i>
                                                                </form>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 grid-margin">
                    <h3 style="color: #957DAD">Undangan Kolaborasi</h3>
                    <div class="card rounded-4">
                        <div class="card-body pt-3">
                            <div class="table-container scrollbar-down thin">
                                <table class="table custom-table" style="">
                                    <thead class="table-header fixed-header">
                                        <tr class="table-row header headerlengkung">
                                            <th class="table-cell"> Artis </th>
                                            <th class="table-cell"> Nama Proyek </th>
                                            <th class="table-cell"> Tanggal </th>
                                            <th class="table-cell"> Status </th>
                                            <th class="table-cell pl-4"> Aksi </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas->reverse() as $item)
                                            @if (
                                                $item->request_project_artis_id_1 !== null ||
                                                    ($item->request_project_artis_id_2 !== null && $item->artist_id === $artisUser->id) ||
                                                    $item->request_project_artis_id_1 === $artisUser->id ||
                                                    $item->request_project_artis_id_2 === $artisUser->id)
                                                @if (empty($item->harga) || in_array($item->status, ['accept', 'pending', 'reject']))
                                                    @if (!$item->is_reject || $item->artis->user_id === auth()->user()->id)
                                                        <tr class="table-row">
                                                            <td class="table-cell">{{ $item->artis->user->name }}</td>
                                                            <td class="table-cell">{{ $item->name }}</td>
                                                            <td class="table-cell">{{ $item->created_at->format('d F Y') }}
                                                            </td>
                                                            <td
                                                                class="table-cell text-success {{ $item->status == 'reject' ? 'text-danger' : '' }} {{ $item->status == 'pending' ? 'text-warning' : '' }}">
                                                                {{ $item->status == 'reject' ? 'Tolak' : '' }}
                                                                {{ $item->status == 'pending' ? 'Menunggu' : '' }}
                                                                {{ $item->status == 'accept' ? 'Selesai' : '' }}
                                                            </td>

                                                            <td class="d-flex align-items-center">
                                                                <button type="button" data-bs-toggle="modal"
                                                                    data-bs-target="#kolaborasiModal-{{ $item->code }}">

                                                                    <!-- Tambahkan ikon mata biru di samping ikon fa-times-circle -->
                                                                    <i class="fas fa-eye text-primary "
                                                                        style="font-size: 20px"></i>
                                                                </button>

                                                                @if ($item->status === 'accept')
                                                                    <button type="submit" class="confirmButton"
                                                                        data-item="{{ $item->code }}">
                                                                        <form
                                                                            action="{{ route('reject.project.artisVerified') }}"
                                                                            method="post" class="m-0">
                                                                            @csrf
                                                                            <input type="hidden" name="code"
                                                                                value="{{ $item->code }}">
                                                                            <input type="hidden" name="is_reject"
                                                                                value="true">

                                                                            <span class="">
                                                                                <i class="far fa-times-circle btn-icon text-danger"
                                                                                    style="font-size: 20px"></i>
                                                                            </span>
                                                                        </form>
                                                                    </button>
                                                                    {{-- <a href="#lagu-diputar"
                                                                        class="flex-grow text-decoration-none link btn"
                                                                        onclick="putar({{ $item->id }})">Putar Lagu</a> --}}
                                                                    <a href="#lagu-diputar"
                                                                        class="flex-grow text-decoration-none link btn"
                                                                        onclick="putar({{ $item->id }})">Putar Lagu</a> 
                                                                @else
                                                                    @if (
                                                                        $item->status !== 'accept' &&
                                                                            (($item->status === 'pending' && $item->is_take) || $artisUser->id == $item->artist_id))
                                                                        <form
                                                                            action="{{ route('lirikAndChat.artisVerified', $item->code) }}"
                                                                            method="GET">
                                                                            <button type="submit" class="btn-unstyled">
                                                                                <i
                                                                                    class="fa-regular fa-comment-dots fs-5 text-info ml-1"></i>
                                                                            </button>
                                                                        </form>
                                                                        <button type="submit" class="confirmButton"
                                                                            data-item="{{ $item->code }}">
                                                                            <form
                                                                                action="{{ route('reject.project.artisVerified') }}"
                                                                                method="post" class="m-0">
                                                                                @csrf
                                                                                <input type="hidden" name="code"
                                                                                    value="{{ $item->code }}">
                                                                                <input type="hidden" name="is_reject"
                                                                                    value="true">
                                                                                <i class="far fa-times-circle btn-icon text-danger"
                                                                                    style="font-size: 20px"></i>
                                                                            </form>
                                                                        </button>
                                                                    @else
                                                                        <form
                                                                            action="{{ route('lirikAndChat.artisVerified', $item->code) }}"
                                                                            method="GET">
                                                                            <button type="submit" class="btn-unstyled">
                                                                                <i
                                                                                    class="fa-regular fa-circle-check fs-5 text-success ml-1"></i>
                                                                            </button>
                                                                        </form>
                                                                        <button type="submit" class="confirmButtonReject"
                                                                            data-item="{{ $item->code }}">
                                                                            <form
                                                                                action="{{ route('reject.project.artisVerified') }}"
                                                                                method="post" class="m-0">
                                                                                @csrf
                                                                                <input type="hidden" name="code"
                                                                                    value="{{ $item->code }}">
                                                                                <input type="hidden" name="is_reject"
                                                                                    value="true">
                                                                                <i class="far fa-times-circle btn-icon text-danger"
                                                                                    style="font-size: 20px"></i>
                                                                            </form>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- untuk detail selesai kolaborasi -->
        @foreach ($datas->reverse() as $item)
            <!-- Modal untuk Proyek Kolaborasi -->
            <div class="modal fade" id="kolaborasiModal-{{ $item->code }}" tabindex="-1"
                aria-labelledby="kolaborasiModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header pb-0">
                            <h4 class="modal-title judul">Detail Proyek Kolaborasi</h4>
                            <button type="button" class="close-button far fa-times-circle" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body" style="padding: 10px 25px 25px;">
                            <div>
                                <p id="kolaborasiModalLabel" class="mb-2">Artis yang berkolaborasi :</p>
                                @if (isset($item->request_project_artis_id_1) && isset($item->request_project_artis_id_2))
                                    <p class="ml-2">
                                        @if ($item->artis)
                                            {{ $item->artis->user->name }}
                                        @endif
                                        @if ($item->artis2)
                                            & {{ $item->artis2->user->name }}
                                        @endif
                                        @if ($item->artis3)
                                            & {{ $item->artis3->user->name }}
                                        @endif
                                    </p>
                                @else
                                    <p class="ml-2">
                                        @if ($item->artis)
                                            {{ $item->artis->user->name }}
                                        @endif
                                        @if ($item->artis2)
                                            & {{ $item->artis2->user->name }}
                                        @endif
                                    </p>
                                @endif
                            </div>
                            <div>
                                <p id="kolaborasiModalLabel" class="mb-2">Nama Proyek :</p>
                                <p class="ml-2">{{ $item->name }}</p>
                            </div>
                            <div>
                                <p id="kolaborasiModalLabel" class="mb-2">Tanggal :</p>
                                <p class="ml-2">{{ $item->created_at->format('d F Y') }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </div>
    </div>
    @endforeach


    {{-- untuk tambah kolab --}}
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title judul" id="exampleModalLabel">Tambah Kolaborasi</h3>
                    <button type="button" class="close-button far fa-times-circle" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('createProject.artisVerified') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="namakategori" class="form-label judulnottebal">Nama Proyek</label>
                            <input type="text" name="name" class="form-control form-i" maxlength="30"
                                id="namaproyek" required>
                        </div>
                        <div class="mb-3">
                            <label for="konsep" class="form-label judulnottebal">Deskripsi</label>
                            <textarea id="konsep" name="konsep" class="form-control" maxlength="500" rows="4" required></textarea>
                        </div>
                        <div class="text-md-right">
                            <button type="submit" class="btn" type="submit">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- untuk detail kolab --}}
    @foreach ($datas as $item)
        <div class="modal fade" id="staticBackdrop-{{ $item->code }}" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #957DAD">Detail
                            Kolaborasi
                        </h1>
                        <button type="button" class="btn-unstyled" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-regular fa-circle-xmark fa-lg btn-icon" style="color: #957DAD"></i>
                        </button>
                    </div>
                    <div class="modal-body border-0">
                        <div class="col-md-12" style="font-size: 13px">
                            <div class="mb-3">
                                <label for="namakategori" class="form-label judulnottebal">Nama
                                    Proyek</label>
                                <input type="text" name="name" class="form-control form-i" id="namaproyek"
                                    required="" readonly="" value="{{ $item->name }}" maxlength="30"
                                    fdprocessedid="piymoo">
                            </div>
                            <div class="mb-3">
                                <label for="konsep" class="form-label judulnottebal">Deskripsi</label>
                                <textarea id="konsep" readonly name="konsep" class="form-control" maxlength="500" rows="4" required>{{ $item->konsep }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn rounded-3" data-bs-toggle="modal"
                            data-bs-target="#undang-{{ $item->code }}">
                            <a href="#" class="btn-link" style="color: inherit; text-decoration: none;">Undang</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- untuk chat --}}
    @foreach ($datas as $project)
        <div class="modal fade" id="chat-{{ $project->code }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #957DAD">Chat
                        </h1>
                        <button type="button" class="btn-unstyled" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-regular fa-circle-xmark fa-lg btn-icon" style="color: #957DAD"></i>
                        </button>
                    </div>
                    <div class="modal-body border-0">
                        <div class="chat" style="margin-top: -20px; position: relative">
                            <form action="{{ route('message.project.artisVerified', $project->code) }}" method="post">
                                @csrf
                                <input type="hidden" name="id_project" value="">
                                <div class="card">
                                    <div style="height: 241px">
                                        <div class="card-body chat-box">
                                            @foreach ($messages as $key => $item)
                                                @if ($project->id === $item->project->id)
                                                    <div class="chat-message mt-1">
                                                        @if ($key == 0 || $item->sender->user->name != $messages[$key - 1]->sender->user->name)
                                                            <div class="chat-name">{{ $item->sender->user->name }}
                                                            </div>
                                                        @endif
                                                        <div class="chat-text">{{ $item->message }}</div>
                                                    </div>
                                                @endIf
                                            @endforeach
                                        </div>
                                        <div class="input-with-icon chat-input">
                                            <input type="text" class="form-control rounded-4" maxlength="50"
                                                placeholder="Ketik di sini untuk admin" name="message"
                                                style="background-color: white;">
                                            <button type="submit" class="send-button ml-2 mr-1">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn rounded-3">
                            <a href="{{ route('lirikAndChat.artisVerified', $project->code) }}" class="btn-link"
                                style="color: inherit; text-decoration: none;">Buat Proyek</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @foreach ($datas as $item)
        <div class="modal fade" id="undang-{{ $item->code }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <form class="modal-dialog modal-dialog-centered" action="{{ route('undangColab', $item->code) }}"
                method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #957DAD">Undang
                            Kolaborator</h1>
                        <button type="button" class="btn-unstyled" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-regular fa-circle-xmark fa-lg btn-icon" style="color: #957DAD"></i>
                        </button>
                    </div>
                    <div class="modal-body border-0">
                        <div class="col-md-12" style="font-size: 13px">
                            <div class="mb-3">
                                <label for="namakategori" class="form-label judulnottebal">Nama
                                    Proyek</label>
                                <input type="text" name="name" class="form-control form-i" id="namaproyek"
                                    required="" readonly="" value="{{ $item->name }}" fdprocessedid="piymoo">
                            </div>
                            <style>
                                #kategori {
                                    width: 100%;
                                    background-color: #f0f0f0;
                                    color: #333;
                                }
                            </style>
                            <div class="mb-3">
                                <label for="namakategori" class="form-label judulnottebal">Nama artis</label>
                                <div class="form-group">
                                    <select class="js-example-basic-multiple" style="width: 100%"
                                        id="kategori-{{ $item->code }}" name="kolaborator[]" multiple="multiple">
                                        @foreach ($artis as $item)
                                            @if ($item->user_id !== auth()->user()->id && $item->is_verified === 1)
                                                <option style="background-color: white" value="{{ $item->id }}">
                                                    {{ $item->user->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn rounded-3 btn-link"
                            style="text-decoration: none;">Undang</button>
                    </div>
                </div>
            </form>
        </div>
    @endforeach
    </div>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                maximumSelectionLength: 2,
                language: {
                    maximumSelected: function(e) {
                        return 'Anda hanya dapat memilih ' + e.maximum + ' opsi.';
                    }
                },
                theme: "classic"
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
