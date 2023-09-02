@extends('admin.components.adminTemplate')
@section('content')
    <link rel="stylesheet" href="/admin/assets/css/riwayat.css">
    <!-- partial | ISI -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="col-lg-12 grid-margin stretch-card">
                <h3 class="judul mb-3">Riwayat Persetujuan Unggah Lagu</h3>
                <div class="table-container">
                    <table class="table table-sortable">
                        <thead>
                            <tr class="table-row table-header">
                                <th class="table-cell">Nama</th>
                                <th class="table-cell">Tanggal </th>
                                <th class="table-cell">Status</th>
                                <th class="table-cell">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-row">
                                <td class="table-cell">
                                    <div class="cell-content">
                                        <img src="../assets/images/faces/face1.jpg" alt="Face" class="avatar">
                                        <div>
                                            <h6>Ada Saja</h6>
                                            <p class="text-muted m-0">tulus</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-cell">03/12/2023</td>
                                <td class="table-cell text-success">Selesai</td>
                                <td class="table-cell">
                                    <button class="btn btnicon">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="table-row">
                                <td class="table-cell">
                                    <div class="cell-content">
                                        <img src="../assets/images/faces/face1.jpg" alt="Face" class="avatar">
                                        <div>
                                            <h6>Katakan Saja</h6>
                                            <p class="text-muted m-0">tulus</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-cell">05/12/2023</td>
                                <td class="table-cell text-success">Selesai</td>
                                <td class="table-cell">
                                    <button class="btn btnicon">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="table-row">
                                <td class="table-cell">
                                    <div class="cell-content">
                                        <img src="../assets/images/faces/face1.jpg" alt="Face" class="avatar">
                                        <div>
                                            <h6>Sudah Cukup</h6>
                                            <p class="text-muted m-0">tulus</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-cell">10/12/2023</td>
                                <td class="table-cell text-success">Selesai</td>
                                <td class="table-cell">
                                    <button class="btn btnicon">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="table-row">
                                <td class="table-cell">
                                    <div class="cell-content">
                                        <img src="../assets/images/faces/face1.jpg" alt="Face" class="avatar">
                                        <div>
                                            <h6>Nemen</h6>
                                            <p class="text-muted m-0">tulus</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-cell">15/12/2023</td>
                                <td class="table-cell text-success">Selesai</td>
                                <td class="table-cell">
                                    <button class="btn btnicon">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="table-row">
                                <td class="table-cell">
                                    <div class="cell-content">
                                        <img src="../assets/images/faces/face1.jpg" alt="Face" class="avatar">
                                        <div>
                                            <h6>Kok Iso Yo</h6>
                                            <p class="text-muted m-0">tulus</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-cell">20/12/2023</td>
                                <td class="table-cell text-success">Selesai</td>
                                <td class="table-cell">
                                    <button class="btn btnicon">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="text-center">
                    <div class="text-center">
                        <ul class="pagination justify-content-center">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>


    <script src="/user/assets/js/tablesort.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        //    $(document).ready(function() {
        // Isi menu dropdown dengan opsi secara dinamis
        //       function populateDropdown(id, options) {
        //         var dropdown = $("#" + id + " + .dropdown-menu");
        //    options.forEach(function(option) {
        //     dropdown.append("<a class='dropdown-item' href='#'>" + option + "</a>");
        // });
        //}

        // Isi dropdown tanggal
        // var tanggalOptions = Array.from({
        // //length: 31
        //}, (_, i) => (i + 1).toString());
        //            populateDropdown("tanggalDropdown", tanggalOptions);

        // Isi dropdown bulan
        //        var bulanOptions = [
        //              "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        //           "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        //    ];
        // populateDropdown("bulanDropdown", bulanOptions);

        // Isi dropdown tahun (dari tahun 2000 hingga tahun sekarang)
        //        var tahunSekarang = new Date().getFullYear();
        //     var tahunOptions = Array.from({
        //          length: tahunSekarang - 1999
        //}, (_, i) => (2000 + i).toString());
        //   populateDropdown("tahunDropdown", tahunOptions);
        //    });

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
