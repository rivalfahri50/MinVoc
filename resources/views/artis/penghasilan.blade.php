@extends('artis.components.artisTemplate')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
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
                gap: 10px;
            }

            .pcard {
                padding: 15px 10px;
            }

            .link {
                color: #85BAD9;
                border: none;
                background: none;
                text-align: left;
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
                                <span class="btn-unstyled mr-2 link mb-0">jika anda ingin mencairkan penghasilan, anda harus
                                    menjadi artis verified terlebih dahulu</span>
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
                                    <div class="modal-body border-0">
                                        <div class="col-md-12" style="font-size: 13px">
                                            <div class="mb-3">
                                                <p for="namakategori" class="form-label judulnottebal">Total Penghasilan</p>
                                                <h3 class="judul">Rp {{ number_format($totalpenghasilan, 2, ',', '.') }}
                                                </h3>
                                            </div>
                                            <div class="mb-3">
                                                <p for="konsep" class="form-label judulnottebal">Jumlah Pencairan</p>
                                                <input type="text" id="harga" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn rounded-3">
                                            <a href="" class="btn-link"
                                                style="color: inherit; text-decoration: none;">Setujui</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8 row no-gutters">
                            <div class="card px-3">
                                <h3 class="judul" style="font-weight: 600">Informasi</h3>
                                <p class="judulnottebal" style="font-size: 12px">Hi, {{ auth()->user()->name }}!
                                    Untuk mencairkan dana Anda sebagai seorang artis, penting untuk diingat bahwa Anda harus
                                    memiliki status 'Artis Verified.' Ini berarti Anda telah melewati proses verifikasi
                                    sebagai seniman di platform kami. Setelah Anda mencapai status ini, Anda dapat mengakses
                                    dan mencairkan pendapatan yang Anda hasilkan dengan karya seni atau kreativitas Anda.
                                </p>
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
                            <form method="get" action="{{ route('filter.date.artis') }}"
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
                            <table class="table" id="onlypaginate">
                                <thead class="table-header">
                                    <tr class="table-row header headerlengkung">
                                        <th class="table-cell">Jumlah</th>
                                        <th class="table-cell">project</th>
                                        <th class="table-cell">Tanggal</th>
                                    </tr>
                                </thead>
                                @if (session('results'))
                                    @if (count(session('results')) >= 1)
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
                                                    <td class="table-cell">{{ $item->created_at->format('j F Y') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        {{-- <table>
                                            <span
                                                style="display: flex; justify-content: center; margin-top: 14px; margin-bottom: 4px; font-size: 14px; color: #4f4f4f">
                                                Tidak ada dalam history pencairan dana.
                                            </span>
                                        </table> --}}
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
                                        {{-- <table>
                                            <span
                                                style="display: flex; justify-content: center; margin-top: 14px; margin-bottom: 4px; font-size: 14px; color: #4f4f4f">
                                                Tidak ada dalam history pencairan dana.
                                            </span>
                                        </table> --}}
                                    @endif
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
