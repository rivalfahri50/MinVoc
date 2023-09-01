@extends('users.components.usersTemplates')

@section('content')
    <div class="main-panel">
        <link rel="stylesheet" href="/user/assets/css/riwayat.css">
        <div class="content-wrapper">
            <div class="row">
                {{-- <div class="col-lg-12 grid-margin stretch-card">
                    <div class="row">
                        <div class="col-3">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle full-width-btn" type="button" id="tanggalDropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tanggal
                                </button>
                                <div class="dropdown-menu dropdown-menu-scroll scrollbar-down"
                                    aria-labelledby="tanggalDropdown">
                                    <!-- Opsi dropdown akan ditambahkan secara dinamis menggunakan JavaScript -->
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle full-width-btn" type="button" id="bulanDropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Bulan
                                </button>
                                <div class="dropdown-menu dropdown-menu-scroll scrollbar-down"
                                    aria-labelledby="bulanDropdown">
                                    <!-- Opsi dropdown akan ditambahkan secara dinamis menggunakan JavaScript -->
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle full-width-btn" type="button" id="tahunDropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tahun
                                </button>
                                <div class="dropdown-menu dropdown-menu-scroll scrollbar-down"
                                    aria-labelledby="tahunDropdown">
                                    <!-- Opsi dropdown akan ditambahkan secara dinamis menggunakan JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="table-container">
                        <table class="table table-sortable">
                            <thead>
                                <tr class="table-row table-header">
                                    <th class="table-cell">Artis</th>
                                    <th class="table-cell">Kategori</th>
                                    <th class="table-cell">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-row">
                                    <td class="table-cell">
                                        <h6>Cindy</h6>
                                        <p class="text-muted m-0">Atulus</p>
                                    </td>
                                    <td class="table-cell">Dangdut</td>
                                    <td class="table-cell">04/09/2023</td>
                                </tr>
                                <tr class="table-row">
                                    <td class="table-cell">
                                        <h6>Bagus</h6>
                                        <p class="text-muted m-0">Dtulus</p>
                                    </td>
                                    <td class="table-cell">Apa</td>
                                    <td class="table-cell">01/09/2023</td>
                                </tr>
                                <tr class="table-row">
                                    <td class="table-cell">
                                        <h6>Agus</h6>
                                        <p class="text-muted m-0">Btulus</p>
                                    </td>
                                    <td class="table-cell">Ciee</td>
                                    <td class="table-cell">02/09/2023</td>
                                </tr>
                                <tr class="table-row">
                                    <td class="table-cell">
                                        <h6>Denis</h6>
                                        <p class="text-muted m-0">Ctulus</p>
                                    </td>
                                    <td class="table-cell">Bajigur</td>
                                    <td class="table-cell">10/10/2023</td>
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
        // $(document).ready(function() {
        //     function populateDropdown(id, options) {
        //         var dropdown = $("#" + id + " + .dropdown-menu");
        //         options.forEach(function(option) {
        //             dropdown.append("<a class='dropdown-item' href='#'>" + option + "</a>");
        //         });
        //     }

        //     var tanggalOptions = Array.from({
        //         length: 31
        //     }, (_, i) => (i + 1).toString());
        //     populateDropdown("tanggalDropdown", tanggalOptions);

        //     var bulanOptions = [
        //         "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        //         "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        //     ];
        //     populateDropdown("bulanDropdown", bulanOptions);

        //     var tahunSekarang = new Date().getFullYear();
        //     var tahunOptions = Array.from({
        //         length: tahunSekarang - 1999
        //     }, (_, i) => (2000 + i).toString());
        //     populateDropdown("tahunDropdown", tahunOptions);

        //     $("#filterButton").click(function() {
        //         var filterData = {
        //             tanggal: $("#tanggalDropdown").val(),
        //             bulan: $("#bulanDropdown").val(),
        //             tahun: $("#tahunDropdown").val(),
        //         };

        //         console.log(filterData);

        //         $.ajax({
        //             type: "POST",
        //             url: "/pengguna/filter", // Sesuaikan dengan URL endpoint Anda
        //             data: filterData,
        //             success: function(response) {
        //                 // Mengupdate tampilan dengan data yang sesuai
        //                 $("#filteredData").html(response.data);
        //             },
        //             error: function(err) {
        //                 console.error(err);
        //             }
        //         });
        //     });
        // });


        $(document).ready(function() {
            var itemsPerPage = 5;

            $(".table-row").hide();

            $(".table-row").slice(0, itemsPerPage).show();

            var numPages = Math.ceil($(".table-row").length / itemsPerPage);

            for (var i = 1; i <= numPages; i++) {
                $(".pagination").append("<li class='page-item'><a class='page-link' href='#'>" + i + "</a></li>");
            }

            if (numPages <= 1) {
                $(".pagination").hide();
            }

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
