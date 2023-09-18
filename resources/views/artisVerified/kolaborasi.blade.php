@extends('artisVerified.components.artisVerifiedTemplate')

{{-- @foreach ($datas as $item)
    <div class="modal fade" id="staticBackdrop-{{ $item->code }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: white">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Kolaborasi</h1>
                    <button type="button" class="btn-unstyled" data-bs-dismiss="modal" aria-label="Close">
                        <i class="mdi mdi-close-circle-outline btn-icon text-danger"></i>
                    </button>
                </div>
                <div class="modal-body ">

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label"><b>Judul Lagu </b><strong class="">:</strong>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" value="{{ $item->name }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label"><b>Deskripsi </b><strong
                                class="">:</strong></label>
                        <div class="col-sm-5">
                            <p class="judul-lagu text-dark">{{ $item->konsep }}</p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-3">
                        <a href="{{ route('lirikAndChat.artisVerified', $item->code) }}" class="btn-link"
                            style="color: inherit; text-decoration: none;">Buat
                            Proyek</a></button>
                </div>
            </div>
        </div>
    </div>
@endforeach --}}

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
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const confirmButton = document.getElementById('confirmButton');

                confirmButton.addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah pengiriman formulir langsung

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

            document.addEventListener('DOMContentLoaded', function() {
                const confirmButtonReject = document.getElementById('confirmButtonReject');
                confirmButtonReject.addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah pengiriman formulir langsung

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

                                                            <button type="button" id="confirmButton">
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
                                            {{-- @dd() --}}
                                            {{-- @if ($item->status == 'pending' && $item->request_project_artis_id !== null) --}}
                                            @if (
                                                $item->request_project_artis_id_1 !== null ||
                                                    ($item->request_project_artis_id_2 !== null && $item->artist_id === $artisUser->id) ||
                                                    $item->request_project_artis_id_1 === $artisUser->id ||
                                                    $item->request_project_artis_id_2 === $artisUser->id)
                                                @if (empty($item->harga))
                                                    @if (!$item->is_reject || $item->artis->user_id === auth()->user()->id)
                                                        <tr class="table-row">
                                                            <td class="table-cell">{{ $item->artis->user->name }}</td>
                                                            <td class="table-cell">{{ $item->name }}</td>
                                                            <td class="table-cell">{{ $item->created_at->format('d F Y') }}
                                                            </td>
                                                            <td
                                                                class="table-cell {{ $item->status === 'reject' ? 'text-danger' : 'text-warning' }}">
                                                                {{ $item->status }}</td>
                                                            <td class="d-flex align-items-center">
                                                                @if ($item->status == 'pending')
                                                                    <form
                                                                        action="{{ route('lirikAndChat.artisVerified', $item->code) }}"
                                                                        method="GET">
                                                                        <button type="submit" class="btn-unstyled">
                                                                            <i
                                                                                class="fa-regular fa-comment-dots fs-5 text-info ml-1"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                                <button type="submit" id="confirmButtonReject">
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
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endif
                                        @endforeach

                                        {{-- <tr class="table-row">
                                            <td class="table-cell">Tulus</td>
                                            <td class="table-cell">Kenangan</td>
                                            <td class="table-cell">13123123</td>
                                            <td class="table-cell text-success">Disetujui</td>
                                            <td class="d-flex align-items-center">
                                                <a href="" class="btn-unstyled" data-bs-toggle="modal"
                                                    data-bs-target="#chat">
                                                    <i class="fa-regular fa-comment-dots text-primary fs-5 ml-1"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <tr class="table-row">
                                            <td class="table-cell">Tulus</td>
                                            <td class="table-cell">Kenangan</td>
                                            <td class="table-cell">13123123</td>
                                            <td class="table-cell text-danger">Ditolak</td>
                                            <td class="d-flex align-items-center">
                                                <form action="{{ route('reject.project.artisVerified') }}" method="post"
                                                    class="m-0">
                                                    @csrf
                                                    <button type="submit">
                                                        <input type="hidden" name="code" value="aa">
                                                        <input type="hidden" name="is_reject" value="true">
                                                        <i class="mdi mdi-close-circle-outline btn-icon text-danger"
                                                            style="font-size: 20px"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                                <a href="#" class="btn-link"
                                    style="color: inherit; text-decoration: none;">Undang</a>
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
                                <form action="{{ route('message.project.artisVerified', $project->code) }}"
                                    method="post">
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
                                        required="" readonly="" value="{{ $item->name }}"
                                        fdprocessedid="piymoo">
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
                                        <select class="js-example-basic-multiple" style="width: 100%" id="kategori"
                                            name="kolaborator[]" multiple="multiple">
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

        <script>
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2({
                    theme: "classic"
                });
            });
        </script>
        {{-- <script>
            $(document).ready(function() {
                // Initialize Select2
                // $('.js-example-basic-multiple').select2();

                // Get a reference to the select element
                let selectElement = $('#kategori');

                // Make an AJAX request to fetch data
                $.ajax({
                    url: `/artis-verified/artis-kolaborasi`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Clear existing options (if any)
                        selectElement.empty();

                        // Add a placeholder option (if needed)
                        selectElement.append('<option value="">Select an option</option>');

                        // Iterate through the response data and add options
                        response.forEach(function(item) {
                            selectElement.append(
                                `<option value="${item.user.name}">${item.user.name}</option>`);
                            console.log("hasil nya " + item.user.name);
                        });

                        // Update Select2 after modifying the options
                        selectElement.trigger('change');
                    }
                });
            });
        </script> --}}

    </div>
@endsection
