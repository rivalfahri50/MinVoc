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
                                <h3 class="angka m-0">Rp {{ number_format($totalpenghasilan, 0,',','.')}}</h3>
                                <h4 class="judulnottebal mb-0">Total penghasilan</h4>
                                @if (isset($penghasilanData->penghasilan) && $penghasilanData->penghasilan >= 500000 && $penghasilanData->penghasilan !== $penghasilanData->penghasilanCair)
                                    <span class="btn-unstyled mr-2 link mb-0" style="cursor: pointer" data-bs-toggle="modal"
                                        data-bs-target="#caripenghasilan">Cairkan Penghasilan</span>
                                @endif
                                @if (isset($penghasilanData->is_take))
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
                                            <div class="col-md-12" style="font-size: 13px">
                                                <div class="mb-3">
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
                            <div class="card py-2 px-3">
                                <p class="judulnottebal">Selamat kembali, Artis Ter-Verifikasi! Nikmati pengalaman istimewa di MusiCave. Jelajahi berbagai fitur dan informasi yang telah kami persiapkan untuk membantu Anda berkembang dalam karier musik Anda. Kami siap mendukung kesuksesan karier musik Anda. Terus berkreasi dan berbagi musik terbaik Anda dengan dunia!</p>
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
                                        @foreach ($projects->reverse() as $item)
                                            {{-- @dd($item) --}}
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
        const code = "{{ auth()->user()->code }}"
        fetch(`/artis-verified/pencairan/${code}`)
            .then(response => response.json())
            .then(data => {
                const inputElement = document.getElementById('harga_pencairan');

                inputElement.value = data.penghasilan.penghasilan;

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
