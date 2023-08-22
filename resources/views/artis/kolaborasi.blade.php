@extends('components.artisTemplate')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row ">
                <div class="col-12 grid-margin">
                    <div class="card">
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
                                        <tr>
                                            <td>
                                                <span class="pl-2">Hati-hati Di Jalan</span>
                                            </td>
                                            <td>
                                                <div>Rp 2.000.000,00</div>
                                            </td>
                                            <td> 08/08/23 </td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn-unstyled" data-bs-toggle="modal"
                                                    data-bs-target="#staticBackdrop">
                                                    <i class="mdi mdi-eye btn-icon text-primary"></i>
                                                </button>

                                                <button class="btn-unstyled">
                                                    <i class="mdi mdi-close-circle-outline btn-icon text-danger"></i>
                                                </button>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>

                                                <span class="pl-2">Estella Bryan</span>
                                            </td>
                                            <td>
                                                <div>Rp 2.000.000,00</div>
                                            </td>
                                            <td> 08/08/23 </td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn-unstyled" data-bs-toggle="modal"
                                                    data-bs-target="#staticBackdrop">
                                                    <i class="mdi mdi-eye btn-icon text-primary"></i>
                                                </button>
                                                <button class="btn-unstyled">
                                                    <i class="mdi mdi-close-circle-outline btn-icon text-danger"></i>
                                                </button>
                                            </td>
                                        </tr>
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
