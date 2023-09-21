<style>
    #tambahkeplaylist {
        width: 100%;
        height: 100%;
        position: fixed;
        background: rgba(0, 0, 0, 0.7);
        top: 0;
        left: 0;
        z-index: 9999;
        visibility: hidden;
    }

    label {
        justify-content: right;
    }

    #tambahkeplaylist .card-body {
        padding: 10px 7% 10px 7%;
    }

    /* Memunculkan Jendela Pop Up Detail*/
    #tambahkeplaylist:target {
        visibility: visible;
    }

    .windowi {
        background-color: #ffffff;
        width: 300px;
        border-radius: 10px;
        position: relative;
        margin: 15% auto;
        padding: 10px;
    }

    .close-button {
        display: block;
        color: #957dad;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .judul {
        font-size: 20px;
    }
</style>
@foreach ($songs as $item)
    <div id="staticBackdrop-{{ $item->code }}" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h4 class="modal-title" id="staticBackdropLabel" style="color: #957DAD">Tambah ke Playlist</h4>
                    <button type="button" style="border: none; background: none;" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-regular fa-circle-xmark fa-lg btn-icon" style="color: #957DAD"></i>
                    </button>
                </div>
                <div class="modal-body border-0">
                    @if (auth()->user()->role_id === 3)
                        <form class="row" action="{{ route('tambah.playlist', $item->code) }}" method="POST">
                    @endif
                    @if (auth()->user()->role_id === 2)
                        <form class="row" action="{{ route('tambah.playlist.artis', $item->code) }}" method="POST">
                    @endif
                    @if (auth()->user()->role_id === 1)
                        <form class="row" action="{{ route('tambah.playlist.artisVerified', $item->code) }}"
                            method="POST">
                    @endif
                    @csrf
                    <div class="col-m`d-12">
                        <div class="mb-4">
                            <h6 for="namaartis" class="form-label judulnottebal mb-2" style="font-weight: 100">Nama
                                Playlist</h6>
                            <select name="playlist_id" class="form-select" id="namaartis">
                                @foreach ($playlists as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <div class="text-md-right">
                        <button class="btn" type="submit" onclick="return validateForm();">Tambah</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
    function validateForm() {
        var selectedOption = document.getElementById("namaartis").value;
        console.log(selectedOption);
        if (!selectedOption) {
            alert("Pilih sebuah playlist terlebih dahulu!");
            return false; // Mencegah pengiriman formulir jika tidak ada opsi yang dipilih
        }
        return true; // Memungkinkan pengiriman formulir jika opsi terpilih
    }
</script>
