@extends('admin.components.adminTemplate')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/admin/assets/css/riwayat.css">
    <style>
        .over {
            width: 170px;
        }

        i:hover {
            color: rebeccapurple;
        }
    </style>
    <!-- partial | ISI -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="col-lg-12 grid-margin stretch-card">
                <h3 class="judul mb-3">Riwayat Persetujuan Unggah Lagu</h3>
                <div class="table-container">
                    <table id="jstabel" class="table">
                        <thead>
                            <tr class="table-row table-header">
                                <th class="table-cell">Nama</th>
                                <th class="table-cell">Artis</th>
                                <th class="table-cell">Tanggal</th>
                                <th class="table-cell">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($songs->reverse() as $item)
                                @if ($item->is_approved)
                                    <tr class="table-row baris">
                                        <td class="table-cell">
                                            <div class="cell-content over">
                                                {{ $item->judul }}
                                            </div>
                                        </td>
                                        <td class="table-cell">{{ $item->artist->user->name }}</td>
                                        </td>
                                        <td class="table-cell">{{ $item->created_at->format('d F Y') }}</td>
                                        <td class="table-cell text-success">
                                            {{ $item->is_approved ? 'Telah Terbit' : 'Tolak' }}
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    @if (count($songs) === 0)
                        <div style="justify-content: center; display: flex; padding: 50px 0;">
                            <img width="400" height="200" src="/icon-notFound/adminIcon.svg" alt=""
                                srcset="">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        jQuery.noConflict();

        jQuery(document).ready(function($) {
            $('#jstabel').DataTable({
                "lengthMenu": [
                    [5, 10, 15, -1],
                    [5, 10, 15, "All"]
                ],
                "pageLength": 5,

                "order": [],

                "bStateSave": true,

                "ordering": false,

                "language": {
                    "sProcessing": "Sedang memproses...",
                    "sLengthMenu": "Tampilkan _MENU_ data",
                    "sZeroRecords": "Tidak ditemukan Data",
                    "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "sInfoFiltered": "(disaring dari _MAX_ data keseluruhan)",
                    "sInfoPostFix": "",
                    "sSearch": "Cari:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "Pertama",
                        "sPrevious": "&#8592;",
                        "sNext": "&#8594;",
                        "sLast": "Terakhir"
                    }
                }
            });
        });
    </script>
@endsection
