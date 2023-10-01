@extends('artis.components.artisTemplate')

@section('content')
    <div class="main-panel">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="/user/assets/css/riwayat.css">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="table-container">
                        <table id="jstabel" class="table">
                            <thead>
                                <tr class="table-row table-header">
                                    <th class="table-cell">Lagu</th>
                                    <th class="table-cell">Kategori</th>
                                    <th class="table-cell">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($uniqueRows->reverse() as $item)
                                    @if ($item->user_id === auth()->user()->id)
                                        <tr class="table-row baris">
                                            <td class="table-cell">
                                                <h6>{{ $item->song->judul }}</h6>
                                                <p class="text-muted m-0">{{ $item->song->artist->user->name }}</p>
                                            </td>
                                            <td class="table-cell">{{ $item->song->genre->name }}</td>
                                            <td class="table-cell">
                                                {{ $item->created_at->diffForHumans() }} </td>
                                        </tr>
                                    @endIf
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if (count($uniqueRows) === 0)
                    <div style="justify-content: center; display: flex; padding: 50px 0;">
                        <img width="400" height="200" src="/user/assets/images/logo-user.svg" alt=""
                            srcset="">
                    </div>
                @endif
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

                "ordering": false,

                "bStateSave": true,

                "language": {
                    "sProcessing": "Sedang memproses...",
                    "sLengthMenu": "Tampilkan _MENU_ entri",
                    "sZeroRecords": "Tidak ditemukan Data",
                    "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
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
