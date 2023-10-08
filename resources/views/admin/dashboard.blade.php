@extends('admin.components.adminTemplate')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
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
                                <h3 class="angka m-0">{{ $totalLagu }}<span class="fas fa-music small ikon"></span></h3>
                                <h4 class="judul mb-3">Lagu</h4>
                                <p class="teks">Sejak 2023</p>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="card coba">
                                <h3 class="angka m-0">{{ $totalArtist }} <span
                                        class="fas fa-microphone-alt small ikon"></span></h3>
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
                            <table class="table" id="onlypaginate">
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
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        jQuery.noConflict();

        jQuery(document).ready(function($) {
            $('#onlypaginate').DataTable({
                "pageLength": 3,

                "ordering": false,

                "bStateSave": true,

                "lengthChange": true,

                "searching": false,

                "sDom": "t<'row'<'col-md-12'p>>",

                "pagingType": 'full_numbers',

                "language": {
                    "sProcessing": "Sedang memproses...",
                    "sLengthMenu": "Tampilkan _MENU_ entri",
                    "sZeroRecords": "Tidak ada dalam history pencairan dana.",
                    "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                    "sInfoPostFix": "",
                    "sSearch": "Cari:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "<<",
                        "sPrevious": "&#8592;",
                        "sNext": "&#8594;",
                        "sLast": ">>"
                    }
                },

                "fnDrawCallback": function(oSettings) {
                    var pgr = $(oSettings.nTableWrapper).find('.dataTables_paginate')
                    if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                        pgr.hide();
                    } else {
                        pgr.show()
                    }
                }
            });
        });
    </script>

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
@endsection
