<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="/user/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/user/assets/css/style.css">
    <link rel="shortcut icon" href="/image/favicon.svg" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,400;0,500;1,100;1,200&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        
        .search-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            width: 100%;
            max-width: 400px;
            /* Set the maximum width as needed */
        }

        /* Style Untuk search input */
        .search-input {
            border-radius: 15px;
            border: 1px solid #eaeaea;
            padding: 5px 10px;
            width: 100%;
        }

        /* Style Untuk search results */
        #search-results {
            list-style: none;
            position: absolute;
            top: 60px;
            left: 30px;
            width: 52%;
            background-color: white;
            border: 1.5px solid #eaeaea;
            padding: 10px;
            display: none;
            border-radius: 10px;
            font-size: 15px
        }


        /* Style Untuk Ukuran foto profil */
        .profile-picture {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #buat-album {
            width: 100%;
            height: 100%;
            position: fixed;
            background: rgba(0, 0, 0, .7);
            top: 0;
            left: 0;
            z-index: 9999;
            visibility: hidden;
        }

        #buat-album .card-body {
            padding: 10px 7% 10px 7%;
        }

        /* Memunculkan Jendela Pop Up*/
        #buat-album:target {
            visibility: visible;
        }

        .window {
            background-color: #ffffff;
            width: 350px;
            border-radius: 10px;
            position: relative;
            margin: 13% auto;
            padding: 10px;
        }

        .close-button {
            display: block;
            color: #957DAD;
            position: absolute;
            top: 10px;
            right: 10px;
        }
        
        
    </style>
    <script>
        // INI SCRIPT UNTUK HASIL SEARCH TAMPIL/TIDAK
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("search");
            const searchResults = document.getElementById("search-results");

            searchInput.addEventListener("input", function() {
                if (searchInput.value.trim() !== "") {
                    searchResults.style.display = "block";
                } else {
                    searchResults.style.display = "none";
                }
            });
        });
    </script>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="/artis/dashboard"><img src="/user/assets/images/logo.svg"
                        alt="logo" /></a>
            </div>
            <ul class="nav">
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis/dashboard">
                        <span class="menu-icon ">
                            <i class="mdi mdi-home"></i>
                        </span>
                        <span class="menu-title">Beranda</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis/playlist">
                        <span class="menu-icon">
                            <i class="mdi mdi-music"></i>
                        </span>
                        <span class="menu-title">Playlist</span>
                        <a href="#ui-basic" data-toggle="collapse" aria-expanded="false" aria-controls="ui-basic">
                            <span class="menu-arrow">
                                <i class="mdi mdi-chevron-right"></i>
                            </span>
                        </a>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('buat.playlist.artis') }}">
                                    <span class="menu-icon">
                                        <i class="mdi mdi-plus-circle-outline"></i>
                                    </span>
                                    <span class="menu-title">Buat Playlist</span>
                                </a>
                                <a class="nav-link" href="#buat-album">
                                    <span class="menu-icon">
                                        <i class="mdi mdi-plus-circle-outline"></i>
                                    </span>
                                    <span class="menu-title">Buat Album</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis/kolaborasi">
                        @if ($title === 'kolaborasi')
                            <span class="menu-icon">
                                <i class="mdi mdi-account-group-outline"></i>
                            </span>
                        @else
                            <span class="menu-icon">
                                <i class="mdi mdi-account-group-outline"></i>
                            </span>
                            <span class="menu-title">Kolaborasi</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis/penghasilan">
                        <span class="menu-icon">
                            <i class="mdi mdi-cash-multiple"></i>
                        </span>
                        <span class="menu-title">Penghasilan</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis/verified">
                        <span class="menu-icon">
                            <i class="mdi mdi-account-check-outline"></i>
                        </span>
                        <span class="menu-title">Verifikasi</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/artis/riwayat">
                        <span class="menu-icon">
                            <i class="mdi mdi-clock-outline"></i>
                        </span>
                        <span class="menu-title">Riwayat</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <ul class="navbar-nav w-75">
                        <ul class="navbar-nav w-75">
                            <li class="nav-item w-75">
                                <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"
                                            style="border-radius: 15px 0px 0px 15px; border: 1px solid #eaeaea">
                                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M18 18L13.9865 13.9795M16.2105 8.60526C16.2105 12.8055 12.8055 16.2105 8.60526 16.2105C4.40499 16.2105 1 12.8055 1 8.60526C1 4.40499 4.40499 1 8.60526 1C12.8055 1 16.2105 4.40499 16.2105 8.60526Z"
                                                    stroke="#957DAD" stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </span>
                                        <input type="text" id="search" class="form-control"
                                            placeholder="cari di sini" style="border-radius: 0px 15px 15px 0px">
                                    </div>
                                </form>
                                <ul id="search-results"></ul>
                            </li>
                        </ul>

                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown"
                                href="#" data-toggle="dropdown">
                                <i class="mdi mdi-bell"></i>
                                <span class="count bg-danger"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="notificationDropdown">
                                <a href="#" class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon rounded-circle">
                                            <img src="/user/assets/images/faces/face12.jpg">
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Gajah</p>
                                        <p class="text-muted ellipsis mb-0"> Tulus </p>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon rounded-circle">
                                            <img src="/user/assets/images/faces/face12.jpg">
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Gajah</p>
                                        <p class="text-muted ellipsis mb-0"> Tulus </p>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon rounded-circle">
                                            <img src="/user/assets/images/faces/face12.jpg">
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Gajah</p>
                                        <p class="text-muted ellipsis mb-0"> Tulus </p>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle" src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                        alt="">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="profileDropdown">
                                <div class="p-3 mb-0 gap-3"
                                    style="display: flex; flex-direction: row; justify-content: center; align-items: center;">
                                    <img class="img-xs rounded-circle" src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                        alt="">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ auth()->user()->name }}</p>
                                </div>
                                <a href="/artis/profile" class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon">
                                            <i class="mdi mdi-account-circle-outline"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Profile</p>
                                    </div>
                                </a>
                                <a class="dropdown-item preview-item" href="{{ route('logout.users') }}">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon rounded-circle">
                                            <i class="mdi mdi-logout"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Log out</p>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>

            @yield('content')

            <div id="buat-album">
                <div class="card window">
                    <div class="card-body">
                        <a href="#" class="close-button far fa-times-circle"></a>
                        <h2 class="judul">Buat Album</h2>
                        <form class="row" action="">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <h3 class="form-label judul">Nama Album</h3>
                                    <input type="text" class="form-control" id="namaproyek" placeholder="Masukkan nama kategori musik"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <h3 for="upload" class="form-label judul">Upload
                                        Foto</h3>
                                    <input type="file" class="form-control" id="namaproyek"
                                        required>
                                </div>
                            </div>
                            <div class="text-md-right">
                                <a href="#" class="btn" type="submit">Tambah</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $('#search').on('keyup', function() {
                        var query = $(this).val();
                        $.ajax({
                            url: '/artis/search/',
                            type: 'GET',
                            data: {
                                query: query
                            },
                            dataType: 'json',
                            success: function(response) {
                                var results = response.results;
                                var $searchResults = $('#search-results');
                                $searchResults.empty();

                                $.each(results, function(index, result) {
                                    $searchResults.append('<li>' + result.name + '</li>');
                                });
                            }
                        });
                    });
                });
            </script>

            <script>
                function myFunction(x) {
                    x.classList.toggle("far");
                    x.classList.toggle("fas");
                    x.classList.toggle("warna-kostum-like");
                }
            </script>

            <script src="/user/assets/vendors/js/vendor.bundle.base.js"></script>
            <script src="/user/assets/vendors/chart.js/Chart.min.js"></script>
            <script src="/user/assets/vendors/progressbar.js/progressbar.min.js"></script>
            <script src="/user/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
            <script src="/user/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
            <script src="/user/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
            <script src="/user/assets/js/off-canvas.js"></script>
            <script src="/user/assets/js/hoverable-collapse.js"></script>
            <script src="/user/assets/js/misc.js"></script>
            <script src="/user/assets/js/settings.js"></script>
            <script src="/user/assets/js/todolist.js"></script>
            <script src="/user/assets/js/dashboard.js"></script>
</body>

</html>
