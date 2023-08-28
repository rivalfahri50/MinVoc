@extends('artis.components.artisTemplate')

@foreach ($datas as $item)
    <div class="modal fade" id="staticBackdrop-{{ $item->code }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Kolaborasi</h1>
                    <button type="button" class="btn-unstyled" data-bs-dismiss="modal" aria-label="Close">
                        <i class="mdi mdi-close-circle-outline btn-icon text-danger"></i>
                    </button>
                </div>
                <div class="modal-body ">

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label"><b>Judul Lagu </b><strong class="">:</strong>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" value="{{ $item->name }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label"><b>Kategori </b><strong class="">:</strong></label>
                        <div class="col-sm-5">
                            <input type="text" readonly class="form-control-plaintext" value="{{ $item->genre }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label"><b>Deskripsi </b><strong
                                class="">:</strong></label>
                        <div class="col-sm-5">
                            <p class="judul-lagu text-dark">{{ $item->konsep }}</p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label"><b>Harga </b><strong class="">:</strong></label>
                        <div class="col-sm-5">
                            <input type="text" readonly class="form-control-plaintext" value="{{ $item->harga }}">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-3">
                        <a href="{{ route('lirikAndChat', $item->code) }}" class="btn-link"
                            style="color: inherit; text-decoration: none;">Buat
                            Proyek</a></button>
                </div>
            </div>
        </div>
    </div>
@endforeach


@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row ">
                <div class="col-12 grid-margin">
                    <div class="card rounded-4">
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table custom-table mt-3" style="background-color: #6c6c6c;">
                                    <thead>
                                        <tr>
                                            <th> Nama Proyek </th>
                                            <th> Harga </th>
                                            <th> Tanggal </th>
                                            <th> Aksi </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $item)
                                            @if (!$item->is_reject && $item->judul == "none" && $item->lirik == "none")
                                                <tr>
                                                    <td>
                                                        <span class="pl-2">{{ $item->name }}</span>
                                                    </td>
                                                    <td>
                                                        <div>Rp {{ $item->harga }}</div>
                                                    </td>
                                                    <td>{{ $item->created_at->toDateString() }}</td>
                                                    <td class="d-flex align-items-center bg-warning">
                                                        <button type="button" class="btn-unstyled" data-bs-toggle="modal"
                                                            data-bs-target="#staticBackdrop-{{ $item->code }}">
                                                            <i class="mdi mdi-eye btn-icon text-primary"></i>
                                                        </button>

                                                        <form action="{{ route('reject.project') }}" method="post"
                                                            class="">
                                                            @csrf
                                                            <button class="btn-unstyled d-block" type="submit">
                                                                <input type="hidden" name="code"
                                                                    value="{{ $item->code }}">
                                                                <input type="hidden" name="is_reject" value="true">
                                                                <i
                                                                    class="mdi mdi-close-circle-outline btn-icon text-danger"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endif
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
@endsection
