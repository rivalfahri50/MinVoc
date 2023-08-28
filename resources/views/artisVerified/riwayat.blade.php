@extends('artisVerified.components.artisVerifiedTemplate')

@section('content')
    <div class="main-panel">
        <link rel="stylesheet" href="/user/assets/css/riwayat.css">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="row">
                        <div class="col-4">
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
                        <div class="col-4">
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
                        <div class="col-4">
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
                </div>
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="table-container">
                        <div class="table">
                            <div class="table-row table-header">
                                <div class="table-cell">Nama dan Artis</div>
                                <div class="table-cell genre">Genre</div>
                                <div class="table-cell tanggal">Tanggal</div>
                            </div>
                            <div class="table-row">
                                <div class="table-cell">
                                    <h6>Labirin</h6>
                                    <p class="text-muted m-0">tulus</p>
                                </div>
                                <div class="table-cell genre">Pop</div>
                                <div class="table-cell tanggal">08/09/2023</div>
                            </div>
                            <div class="table-row">
                                <div class="table-cell">
                                    <h6>Labirin</h6>
                                    <p class="text-muted m-0">tulus</p>
                                </div>
                                <div class="table-cell genre">Pop</div>
                                <div class="table-cell tanggal">08/09/2023</div>
                            </div>
                            <div class="table-row">
                                <div class="table-cell">
                                    <h6>Labirin</h6>
                                    <p class="text-muted m-0">tulus</p>
                                </div>
                                <div class="table-cell genre">Pop</div>
                                <div class="table-cell tanggal">08/09/2023</div>
                            </div>
                            <div class="table-row">
                                <div class="table-cell">
                                    <h6>Labirin</h6>
                                    <p class="text-muted m-0">tulus</p>
                                </div>
                                <div class="table-cell genre">Pop</div>
                                <div class="table-cell tanggal">08/09/2023</div>
                            </div>
                            <div class="table-row">
                                <div class="table-cell">
                                    <h6>Labirin</h6>
                                    <p class="text-muted m-0">tulus</p>
                                </div>
                                <div class="table-cell genre">Pop</div>
                                <div class="table-cell tanggal">08/09/2023</div>
                            </div>
                        </div>
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


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            function populateDropdown(id, options) {
                var dropdown = $("#" + id + " + .dropdown-menu");
                options.forEach(function(option) {
                    dropdown.append("<a class='dropdown-item' href='#'>" + option + "</a>");
                });
            }

            var tanggalOptions = Array.from({
                length: 31
            }, (_, i) => (i + 1).toString());
            populateDropdown("tanggalDropdown", tanggalOptions);

            // Isi dropdown bulan
            var bulanOptions = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            populateDropdown("bulanDropdown", bulanOptions);

            var tahunSekarang = new Date().getFullYear();
            var tahunOptions = Array.from({
                length: tahunSekarang - 1999
            }, (_, i) => (2000 + i).toString());
            populateDropdown("tahunDropdown", tahunOptions);
        });

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
