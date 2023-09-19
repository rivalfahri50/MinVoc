@extends('admin.components.adminTemplate')

@section('content')
    <link rel="stylesheet" href="/admin/assets/css/iklan.css">
    <!-- partial | ISI -->
    <div class="main-panel">
        <style>
            .form-control {
                color: #495057;
            }

            .form-select {
                background-color: #EAEAEA;
                border: 1px solid #EAEAEA;
                color: #495057;
                font-size: 0.875rem;
            }

            .gambar-container {
                display: flex;
                align-items: center;
            }

            .gambarbg {
                width: 190px;
                height: 90px;
                margin-right: 10px;
                border-radius: 0;
                object-fit: cover;
                /* Mengisi kotak gambar tanpa mempertahankan aspek asli */
            }

            .avatar {
                width: 90px;
                height: 90px;
                /* Ketinggian tetap 60px */
                margin-right: 10px;
                border-radius: 0;
                /* Untuk membuatnya segi empat berbentuk lingkaran */
                object-fit: cover;
                /* Mengisi kotak gambar tanpa mempertahankan aspek asli */
            }

            .table-cell {
                overflow: hidden;
                text-overflow: ellipsis;
                /* Menampilkan "..." jika teks terlalu panjang */
                white-space: nowrap;
                /* Mencegah teks untuk melipat (wrap) */
                max-width: 150px;
                /* Sesuaikan dengan lebar maksimum yang Anda inginkan */
            }

            .image {
                width: 100%;
                /* Mengatur lebar elemen div agar mengisi lebar kontainer */
            }

            .wide-image {
                width: 100%;
                /* Mengatur lebar gambar agar mengisi lebar elemen div */
                height: auto;
                /* Mengatur ketinggian gambar agar mengikuti aspek rasio asli */
                max-width: none;
                /* Menghilangkan pembatasan lebar maksimum jika ada */
            }

            .combined-image {
                position: relative;
            }

            .combined-image .background {

                width: 100%;
                height: auto;
                object-fit: cover;
            }

            .combined-image .artis {

                position: absolute;
                top: 0;
                left: 0;
                width: 10%;
                height: auto;
            }
        </style>
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="row">
                        <div class="sejajar">
                            <h3 class="judul">Papan iklan</h3>
                            <div class="text-lg-end mb-3">
                                <a href="#popuptambah" class="btn full-width-btn" type="button">
                                    <i class="fas fa-plus"></i>
                                    Tambah iklan
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="table-body">
                                    <div class="table-container">
                                        <table class="table">
                                            <thead class="table-header">
                                                <tr class="table-row headerlengkung">
                                                    <th class="table-cell">Gambar</th>
                                                    <th class="table-cell">Nama Artis</th>
                                                    <th class="table-cell">Deskripsi</th>
                                                    <th class="table-cell">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($billboards->reverse() as $item)
                                                    <tr class="table-row">
                                                        <td class="table-cell">
                                                            <div class="image">
                                                                <img src="{{ asset('storage/' . $item->image_background) }}"
                                                                    alt="image_background" class="wide-image">
                                                        </td>
                                                        <td class="table-cell">{{ $item->artis->user->name }}</td>
                                                        <td class="table-cell">{{ $item->deskripsi }}</td>
                                                        <td class="table-cell">
                                                            <button class="btn btnicon" data-bs-toggle="modal"
                                                                data-bs-target="#staticBackdrop-{{ $item->code }}">
                                                                <i class="far fa-eye text-info"></i>
                                                            </button>
                                                            <button type="button" class="btn btnicon" data-toggle="modal"
                                                                data-target="#exampleModalCenter{{ $item->id }}">
                                                                <i class="fas fa-pencil-alt " style="color: #5b6b89"></i>
                                                            </button>
                                                            <button class="btn btnicon"
                                                                onclick="deleteBillboard('{{ $item->code }}')">
                                                                <i class="far fa-times-circle text-danger"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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

                    @if (count($billboards) === 0)
                        <div style="justify-content: center; display: flex; padding: 50px 0;">
                            <img width="400" height="200" src="/icon-notFound/adminIcon.svg" alt=""
                                srcset="">
                        </div>
                    @endif

                    <!-- popup -->
                    <div id="popuptambah">
                        <div class="card window">
                            <div class="card-body">
                                <a href="#" class="close-button far fa-times-circle"></a>
                                <h3 class="judul">Tambah Iklan</h3>
                                <form class="row" action="{{ route('uploadBillboard') }}" enctype="multipart/form-data"
                                    method="POST" id="billboardForm">
                                    @csrf
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="namaartis" class="form-label judulnottebal">Nama artis</label>
                                            <select required name="artis_id" required class="form-select" id="namaartis">
                                                <option disabled selected>artis</option>
                                                @foreach ($artist as $item)
                                                    <option value="{{ $item->id }}">{{ $item->user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label judulnottebal">Deskripsi</label>
                                            <textarea id="deskripsi" name="deskripsi" class="form-control" maxlength="500" rows="6"
                                                placeholder="Masukkan deskripsi" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="uploadlatar" class="form-label judulnottebal">Upload Background
                                                Iklan</label>
                                            <input type="file" name="image_background" class="form-control form-i"
                                                id="uploadlatar" accept=".jpeg, .jpg, .png, .gif" required>
                                            <span id="image-background-error" style="color: red;"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="uploadartis" class="form-label judulnottebal">Upload Foto
                                                Artis</label>
                                            <input type="file" name="image_artis" class="form-control form-i"
                                                id="uploadartis" accept=".jpeg, .jpg, .png, .gif" required>
                                            <span id="image-artis-error" style="color: red;"></span>
                                        </div>
                                    </div>
                                    <div class="text-md-right">
                                        <button class="btn" type="submit">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        // Validasi jenis file saat formulir dikirim
                        document.getElementById('billboardForm').addEventListener('submit', function(event) {
                            const backgroundInput = document.getElementById('uploadlatar');
                            const artisInput = document.getElementById('uploadartis');
                            const backgroundError = document.getElementById('image-background-error');
                            const artisError = document.getElementById('image-artis-error');
                            const validExtensions = ['.jpeg', '.jpg', '.png', '.gif'];

                            function validateFile(input, errorElement) {
                                if (input.files.length > 0) {
                                    const fileName = input.files[0].name;
                                    const fileExtension = '.' + fileName.split('.').pop().toLowerCase();
                                    if (!validExtensions.includes(fileExtension)) {
                                        errorElement.textContent = 'Foto harus berupa JPEG, JPG, PNG, atau GIF.';
                                        event.preventDefault();
                                    } else {
                                        errorElement.textContent = '';
                                    }
                                }
                            }

                            validateFile(backgroundInput, backgroundError);
                            validateFile(artisInput, artisError);
                        });
                    </script>

                    @foreach ($billboards->reverse() as $item)
                        <div id="staticBackdrop-{{ $item->code }}" class="modal">
                            <div class="card window">
                                <div class="card-body">
                                    <a href="" class="close-button far fa-times-circle"></a>
                                    <h3 class="judul">Detail Papan Iklan</h3>
                                    <form class="row" action="">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="namakategori" class="form-label judulnottebal">Nama
                                                    artis</label>
                                                <input type="text" class="form-control form-i" id="namaproyek"
                                                    value="{{ $item->artis->user->name }}" readonly disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label judulnottebal">Deskripsi</label>
                                                <textarea id="deskripsi" class="form-control" maxlength="500" rows="4" readonly disabled>{{ $item->deskripsi }}</textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="namakategori" class="form-label judulnottebal">Gambar
                                                            background
                                                            iklan</label>
                                                        <div class="cell-content gambar-container">
                                                            <img src="{{ asset('storage/' . $item->image_background) }}"
                                                                alt="Face" class="gambarbg">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="namakategori" class="form-label judulnottebal">Gambar
                                                            artis</label>
                                                        <div class="cell-content gambar-container">
                                                            <img src="{{ asset('storage/' . $item->image_artis) }}"
                                                                alt="Face" class="avatar">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <!-- page-body-wrapper ends -->
            </div>
            <!-- container-scroller -->
            @foreach ($billboards->reverse() as $item)
                <div class="modal fade" id="exampleModalCenter{{ $item->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="card window">
                        <div class="card-body">
                            <a href="" class="close-button far fa-times-circle"></a>
                            <h3 class="judul">Edit Iklan</h3>
                            <form class="row" action="{{ route('updateBillboard', $item->code) }}" method="POST"
                                enctype="multipart/form-data" id="editBillboardForm{{ $item->id }}">
                                @csrf

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="namaartis" class="form-label judulnottebal">Nama artis</label>
                                        <select required name="artis_id" class="form-select"
                                            id="namaartis{{ $item->id }}">
                                            @foreach ($artist as $artis)
                                                <option value="{{ $artis->id }}"
                                                    {{ $artis->id == $item->artis_id ? 'selected' : '' }}>
                                                    {{ $artis->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label judulnottebal">Deskripsi</label>
                                        <textarea id="deskripsi" class="form-control" maxlength="500" rows="4" name="deskripsi">{{ $item->deskripsi }}</textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="uploadlatar" class="form-label judulnottebal">Upload Background Iklan</label>
                                                <input type="file" name="image_background" class="form-control form-i" id="uploadlatar{{ $item->id }}">
                                                <span id="image-background-error{{ $item->id }}" style="color: red;"></span>
                                                <img id="background-image-preview{{ $item->id }}" src="{{ $item->image_background ? asset('storage/' . $item->image_background) : '' }}" alt="Foto Lama" class="gambarbg">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="uploadartis" class="form-label judulnottebal">Upload Foto Artis</label>
                                                <input type="file" name="image_artis" class="form-control form-i" id="uploadartis{{ $item->id }}">
                                                <span id="image-artis-error{{ $item->id }}" style="color: red;"></span>
                                                <img id="artis-image-preview{{ $item->id }}" src="{{ $item->image_artis ? asset('storage/' . $item->image_artis) : '' }}" alt="Foto Lama" class="avatar">
                                            </div>
                                         </div>
                                    </div>
                                </div>
                                <div class="text-md-right">
                                    <button class="btn" type="submit">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            <script>
                 function previewImage(input, preview) {
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(file);
        } else {
            // Jika tidak ada file yang dipilih, kosongkan gambar
            preview.src = '';
        }
    }

    // Tambahkan event listener untuk setiap input gambar
    document.getElementById('uploadlatar{{ $item->id }}').addEventListener('change', function () {
        previewImage(this, document.getElementById('background-image-preview{{ $item->id }}'));
    });

    document.getElementById('uploadartis{{ $item->id }}').addEventListener('change', function () {
        previewImage(this, document.getElementById('artis-image-preview{{ $item->id }}'));
    });

                //po
                @foreach ($billboards as $item)
                    document.getElementById('editBillboardForm{{ $item->id }}').addEventListener('submit', function(event) {
                        const backgroundInput = document.getElementById('uploadlatar{{ $item->id }}');
                        const artisInput = document.getElementById('uploadartis{{ $item->id }}');
                        const backgroundError = document.getElementById('image-background-error{{ $item->id }}');
                        const artisError = document.getElementById('image-artis-error{{ $item->id }}');
                        const validExtensions = ['.jpeg', '.jpg', '.png', '.gif'];

                        function validateFile(input, errorElement) {
                            if (input.files.length > 0) {
                                const fileName = input.files[0].name;
                                const fileExtension = '.' + fileName.split('.').pop().toLowerCase();
                                if (!validExtensions.includes(fileExtension)) {
                                    errorElement.textContent = 'Foto harus berupa JPEG, JPG, PNG, atau GIF.';
                                    event.preventDefault();
                                } else {
                                    errorElement.textContent = '';
                                }
                            }
                        }

                        validateFile(backgroundInput, backgroundError);
                        validateFile(artisInput, artisError);
                    });
                @endforeach
            </script>


            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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


                /*================Pagination===================*/

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
