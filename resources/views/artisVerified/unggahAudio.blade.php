@extends('artisVerified.components.artisVerifiedTemplate')

{{-- @extends('artis.components.artisTemplate') --}}


@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/user/assets/css/unggah.css">
    <style>
        select {
            min-height: 0;
        }
    </style>
    <div class="main-panel">
        <div class="content-wrapper">
            <form class="row mb-3" action="{{ route('unggah.artisVerified') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col d-flex flex-row gap-4">
                    <div>
                        <div class="card cobai">
                            <label for="tamel" id="tampil_tamel">
                                <svg width="68" height="79" viewBox="0 0 68 79" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M37.2598 70.3601H11.1779C10.1898 70.3601 9.24204 69.9483 8.54328 69.2153C7.84452 68.4822 7.45196 67.4881 7.45196 66.4514V11.7295C7.45196 10.6929 7.84452 9.69869 8.54328 8.96566C9.24204 8.23264 10.1898 7.82083 11.1779 7.82083H29.8079V19.5469C29.8079 22.6569 30.9855 25.6395 33.0818 27.8386C35.1781 30.0376 38.0212 31.2731 40.9858 31.2731H52.1638V39.0905C52.1638 40.1271 52.5563 41.1213 53.2551 41.8543C53.9538 42.5874 54.9015 42.9992 55.8897 42.9992C56.8779 42.9992 57.8256 42.5874 58.5244 41.8543C59.2232 41.1213 59.6157 40.1271 59.6157 39.0905V27.3644C59.6157 27.3644 59.6157 27.3643 59.6157 27.1298C59.5769 26.7708 59.502 26.417 59.3922 26.0745V25.7227C59.213 25.3208 58.974 24.9514 58.6842 24.6283L36.3283 1.17603C36.0203 0.871995 35.6682 0.62131 35.2851 0.433375C35.1738 0.416803 35.0609 0.416803 34.9497 0.433375C34.5712 0.205659 34.1532 0.0594852 33.7201 0.00341797H11.1779C8.21337 0.00341797 5.37022 1.23884 3.27395 3.43792C1.17767 5.63699 0 8.61957 0 11.7295V66.4514C0 69.5614 1.17767 72.5439 3.27395 74.743C5.37022 76.9421 8.21337 78.1775 11.1779 78.1775H37.2598C38.248 78.1775 39.1957 77.7657 39.8945 77.0327C40.5932 76.2997 40.9858 75.3055 40.9858 74.2688C40.9858 73.2322 40.5932 72.238 39.8945 71.5049C39.1957 70.7719 38.248 70.3601 37.2598 70.3601ZM37.2598 13.3321L46.9101 23.4556H40.9858C39.9976 23.4556 39.0499 23.0438 38.3511 22.3108C37.6524 21.5778 37.2598 20.5836 37.2598 19.5469V13.3321ZM18.6299 23.4556C17.6417 23.4556 16.694 23.8675 15.9952 24.6005C15.2965 25.3335 14.9039 26.3277 14.9039 27.3644C14.9039 28.401 15.2965 29.3952 15.9952 30.1282C16.694 30.8612 17.6417 31.2731 18.6299 31.2731H22.3559C23.3441 31.2731 24.2918 30.8612 24.9906 30.1282C25.6893 29.3952 26.0819 28.401 26.0819 27.3644C26.0819 26.3277 25.6893 25.3335 24.9906 24.6005C24.2918 23.8675 23.3441 23.4556 22.3559 23.4556H18.6299ZM40.9858 39.0905H18.6299C17.6417 39.0905 16.694 39.5023 15.9952 40.2353C15.2965 40.9683 14.9039 41.9625 14.9039 42.9992C14.9039 44.0358 15.2965 45.03 15.9952 45.763C16.694 46.4961 17.6417 46.9079 18.6299 46.9079H40.9858C41.974 46.9079 42.9217 46.4961 43.6205 45.763C44.3192 45.03 44.7118 44.0358 44.7118 42.9992C44.7118 41.9625 44.3192 40.9683 43.6205 40.2353C42.9217 39.5023 41.974 39.0905 40.9858 39.0905ZM65.9871 59.7675L58.5352 51.9501C58.1808 51.5943 57.763 51.3153 57.3056 51.1293C56.3985 50.7383 55.381 50.7383 54.4739 51.1293C54.0165 51.3153 53.5986 51.5943 53.2443 51.9501L45.7923 59.7675C45.0907 60.5035 44.6965 61.5018 44.6965 62.5427C44.6965 63.5836 45.0907 64.5818 45.7923 65.3179C46.4939 66.0539 47.4455 66.4674 48.4378 66.4674C49.43 66.4674 50.3816 66.0539 51.0832 65.3179L52.1638 64.1453V74.2688C52.1638 75.3055 52.5563 76.2997 53.2551 77.0327C53.9538 77.7657 54.9015 78.1775 55.8897 78.1775C56.8779 78.1775 57.8256 77.7657 58.5244 77.0327C59.2232 76.2997 59.6157 75.3055 59.6157 74.2688V64.1453L60.6963 65.3179C61.0426 65.6842 61.4547 65.975 61.9088 66.1735C62.3628 66.3719 62.8498 66.4741 63.3417 66.4741C63.8336 66.4741 64.3206 66.3719 64.7746 66.1735C65.2287 65.975 65.6408 65.6842 65.9871 65.3179C66.3364 64.9545 66.6136 64.5222 66.8027 64.0459C66.9919 63.5696 67.0893 63.0587 67.0893 62.5427C67.0893 62.0267 66.9919 61.5158 66.8027 61.0395C66.6136 60.5632 66.3364 60.1309 65.9871 59.7675ZM33.5338 62.5427C34.522 62.5427 35.4697 62.1309 36.1685 61.3979C36.8673 60.6648 37.2598 59.6706 37.2598 58.634C37.2598 57.5973 36.8673 56.6031 36.1685 55.8701C35.4697 55.1371 34.522 54.7253 33.5338 54.7253H18.6299C17.6417 54.7253 16.694 55.1371 15.9952 55.8701C15.2965 56.6031 14.9039 57.5973 14.9039 58.634C14.9039 59.6706 15.2965 60.6648 15.9952 61.3979C16.694 62.1309 17.6417 62.5427 18.6299 62.5427H33.5338Z"
                                        fill="#957DAD" />
                                </svg>
                            </label>
                            <input type="file" id="tamel" name="image" value="{{ old('image') }}"
                                accept="image/*">
                        </div>
                        @error('image')
                            <div class="text-danger" style="font-size: 14px; width: 170px">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex flex-column mb-3 col-lg-9">
                        <div class="d-flex flex-row justify-content-around">
                            <div class="col-md-8">
                                <input type="text" class="form-control" style="border-radius: 13px"
                                    id="exampleFormControlInput1" placeholder="Judul Lagu" name="judul"
                                    value="{{ old('judul') }}" maxlength="55">
                                @error('judul')
                                    <div class="text-danger" style="font-size: 14px">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <select name="album" class="form-select" style="border-radius: 13px"
                                    aria-label="Default select example">
                                    <option value="" disabled selected>Album</option>
                                    @foreach ($albums as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('album')
                                    <div class="text-danger" style="font-size: 14px">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="my-2 d-flex flex-row justify-content-around">
                            <div class="col-md-8">
                                <input type="file" class="form-control" style="border-radius: 13px" id="inputGroupFile04"
                                    aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="audio"
                                    value="{{ old('audio') }}" accept="mp3">
                                @error('audio')
                                    <div class="text-danger" style="font-size: 14px">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <select name="genre" class="form-select" style="border-radius: 13px"
                                    aria-label="Default select example">
                                    <option value="" disabled selected>Music Genre</option>
                                    @foreach ($genres as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('genre')
                                    <div class="text-danger" style="font-size: 14px">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="my-2">
                            <button type="submit" class="btn w-100 text-white py-2"
                                style="border-radius: 20px; background-color: #957DAD">Unggah</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-lg-12 grid-margin stretch-card">
                <div>
                    <table id="onlypaginate" class="table">
                        <thead>
                            <tr class="table-row table-header">
                                <th class="table-cell">Lagu</th>
                                <th class="table-cell">Genre</th>
                                <th class="table-cell">Tanggal</th>
                                <th class="table-cell">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas->reverse() as $item)
                                @if ($item->artis_id === $artis->id)
                                    <tr class="table-row">
                                        <td class="table-cell">
                                            <div class="cell-content">
                                                <img width="50" src="{{ asset('storage/' . $item->image) }}"
                                                    alt="Face" class="avatar">
                                                <div>
                                                    <h6>{{ $item->judul }}</h6>
                                                    <p class="text-muted m-0">{{ $item->artist->user->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="table-cell">{{ $item->genre->name }}</td>
                                        <td class="table-cell">{{ $item->created_at->format('d F Y') }}</td>
                                        <td class="table-cell {{ $item->is_approved == 0 ? 'text-warning' : 'text-success' }}"
                                            style="font-weight: 400">
                                            {{ $item->is_approved == 0 ? 'Menunggu' : 'Telah Terbit' }}</td>
                                    </tr>
                                @endIf
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @php
                    $filteredData = $datas->filter(function ($item) use ($artis) {
                        return $item->artis_id == $artis->id && ($item->is_approved == true || $item->is_approved == false);
                    });
                @endphp

                @if ($filteredData->count() == 0)
                    <table>
                        <div style="justify-content: center; display: flex; padding: 50px 0;">
                            <img width="400" height="200" src="/user/assets/images/logo-user.svg" alt=""
                                srcset="">
                        </div>
                    </table>
                @endif
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

                "language": {
                    "sProcessing": "Sedang memproses...",
                    "sLengthMenu": "Tampilkan _MENU_ entri",
                    "sZeroRecords": "Tidak ditemukan Data",
                    "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                    "sInfoPostFix": "",
                    "sSearch": "Cari:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "Pertama",
                        "sPrevious": "&#8592;",
                        "sNext": "&#8594;",
                        "sLast": "Terakhir"
                    }
                }
            });
        });
    </script>

    <script>
        const gambar = document.querySelector("#tamel");
        const tampilGambar = document.querySelector("#tampil_tamel");

        gambar.addEventListener("change", function() {
            const reader = new FileReader();

            reader.addEventListener("load", () => {
                tampilGambar.style.backgroundImage = `url(${reader.result})`;
                // Hide the icon when an image is displayed
                tampilGambar.querySelector("svg").style.display = "none";
            });

            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
