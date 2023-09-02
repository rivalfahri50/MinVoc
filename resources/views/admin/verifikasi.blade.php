@extends('admin.components.adminTemplate')
@section('content')
    <link rel="stylesheet" href="/admin/assets/css/verifikasi.css">
    <!-- partial | ISI -->
    <div class="main-panel">
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
                                        <tr class="table-row ">
                                            @foreach ($artist as $item)
                                                <td class="table-cell">
                                                    <div class="cell-content mt-1">
                                                        <img src="{{ asset('storage/' . $item->user->avatar) }}"
                                                            alt="Face" class="avatar mt-1">
                                                        <div>
                                                            <p>{{ $item->user->name }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="table-cell mt-1">{{ $item->pengajuan_verified_at }}</td>
                                                <td class="table-cell text-warning mt-1">{{ $item->verification_status }}
                                                </td>
                                                <td class="table-cell">
                                                    <a href="#popup-{{ $item->code }}" class="btn btnicon mt-1">
                                                        <i class="far fa-eye text-info"></i>
                                                    </a>
                                                    <button class="btn btnicon mt-1">
                                                        <i class="far fa-times-circle text-danger"></i>
                                                    </button>
                                                </td>
                                            @endforeach
                                        </tr>
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

    <!-- popup -->
    @foreach ($artist as $item)
        <div id="popup-{{ $item }}">
            <div class="card window">
                <div class="card-body">
                    <a href="#" class="close-button far fa-times-circle"></a>
                    <h3 class="judul">Detail Pengajuan Verifikasi Akun</h3>
                    <div class="row mt-4">
                        <div class="col-md-12 mb-4">
                            <h5 class="judul mb-3">Nama :</h5>
                            <td class="table-cell">
                                <div class="cell-content">
                                    <img src="../assets/images/faces/face1.jpg" alt="Face" class="avatar">
                                    <div>
                                        <p class="teksbiasa">Johan Akbar</p>
                                    </div>
                                </div>
                            </td>
                        </div>
                        <div class="col-md-12 mb-4">
                            <h5 class="judul mb-3">Tanggal Pengajuan :</h5>
                            <p class="teksbiasa">10/08/2023</p>
                        </div>
                        <div class="text-md-right">
                            <a href="#" class="btn" type="submit">Setujui</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        /*===================================*/

        $(document).ready(function() {
            var itemsPerPage = 5;

            // Menyembunyikan semua baris tabel
            $(".table-row").hide();


            // Menampilkan 'itemsPerPage' baris pertama
            $(".table-row").slice(0, itemsPerPage).show();


            // Menghitung jumlah halaman
            var numPages = Math.ceil($(".table-row").length / itemsPerPage);


            // Menambahkan item-item paginatio
            for (var i = 1; i <= numPages; i++) {
                $(".pagination").append("<li class='page-item'><a class='page-link' href='#'>" + i + "</a></li>");
            }

            // Menyembunyikan atau menampilkan pagination berdasarkan jumlah halaman
            if (numPages <= 1) {
                $(".pagination").hide();
            }

            // Mengatur pengklikan pagination
            $(".pagination a").click(function(e) {
                e.preventDefault();
                var page = $(this).text();
                var start = (page - 1) * itemsPerPage;
                var end = start + itemsPerPage;
                $(".table-row").hide();
                $(".table-row").slice(start, end).show();
                $(".pagination a").removeClass("active");
                $(this).addClass("active");
            });

            // Menampilkan halaman sebelumnya saat tombol '<<' diklik
            $(".pagination .prev").click(function(e) {
                e.preventDefault();
                var activePage = $(".pagination .active").text();
                var prevPage = parseInt(activePage) - 1;
                if (prevPage >= 1) {
                    $(".pagination a").eq(prevPage - 1).click();
                }
            });
        });
    </script>
@endsection
