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
                gap: 10px;
            }

            .pcard {
                padding: 15px 10px;
            }

            .link {
                color: #96D1F4;
            }
        </style>
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="row">
                        <div class="col-4">
                            <div class="card pcard jarak">
                                <h3 class="angka m-0">Rp 20.000.000</h3>
                                <h4 class="judulnottebal mb-0">Total penghasilan</h4>
                                <span href="" class="link mb-0"><a style="color: #d291bc" href="">Cairkan Penghasilan</a></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card pcard jarak" style="height: 100%;">
                                <h3 class="angka m-0">Rp 10.000.000</h3>
                                <h4 class="judulnottebal">Sisa Penghasilan</h4>
                            </div>
                        </div>
                        <div class="col-4 row no-gutters">
                            <div class="card">
                                <img src="/assets/images/logo.svg" width="80%" height="100%" alt="logo"
                                    class="ml-4 md-3" />
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

                {{-- @dd($projects) --}}

                <div class="col-md-12">
                    <h3 class="judul">Riwayat Penghasilan Masuk</h3>
                    <div class="card mb-3">
                        <div class="table-body">
                            <div class="table-container">
                                <table class="table">
                                    <thead class="table-header">
                                        <tr class="table-row header headerlengkung">
                                            <th class="table-cell">Kolaborasi</th>
                                            <th class="table-cell">Jumlah</th>
                                            <th class="table-cell">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projects as $item)
                                            <tr class="table-row">
                                                <td class="table-cell">
                                                    <div class="cell-content">
                                                        <img src="{{ asset('storage/' . $item->images) }}" alt="Face"
                                                            class="avatar">
                                                        <div>
                                                            <h6>{{ $item->judul }}</h6>
                                                            <p class="text-muted m-0">{{ $item->artis->user->name }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="table-cell">{{ $item->harga }}</td>
                                                <td class="table-cell">{{ $item->created_at->toDateString() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="/user/assets/js/tablesort.js"></script>
    <script>
        function myFunction(x) {
            x.classList.toggle("far"); // Menghapus kelas "fa fa-heart"
            x.classList.toggle("fas"); // Menambahkan kelas "fas fa-heart"
            x.classList.toggle("warna-kostum-like"); // Menambahkan kelas warna merah
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');

        var dataPendapatan = <?php echo json_encode($penghasilan->penghasilan); ?>;

        var labels = Object.keys(dataPendapatan);
        var pendapatanBulanan = Object.values(dataPendapatan);

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: pendapatanBulanan,
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
                    borderWidth: 1
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
