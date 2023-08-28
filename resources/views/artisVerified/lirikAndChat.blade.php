@extends('artisVerified.components.artisVerifiedTemplate')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-7 grid-margin stretch-card">
                    <div class="card kiri scrollbar-dusty-grass square thin rounded-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="preview-list">
                                        <form action="{{ route('create.project') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="code" value="{{ $project[0]->code }}">
                                            <div class="preview-item">
                                                <div class="preview-item-content d-sm-flex flex-grow mb-2">
                                                    <h3 class="fw-semibold" style="color: #957dad; margin-top: -30px;">
                                                        Project
                                                        {{ $project[0]->name }}</h3>
                                                </div>
                                            </div>
                                            <div class="mb-3" style="margin-top: -20px;">
                                                <input type="text" class="input-judul pl-3" id="exampleFormControlInput1"
                                                    placeholder="Judul Lagu" name="judul">
                                            </div>
                                            <div class="mb-3">
                                                <textarea class="input-judul summernote" id="exampleFormControlTextarea1" rows="3" name="lirik"></textarea>
                                            </div>
                                            <div class="mb-3" style="margin-top: 5px;">
                                                <button class="btn btn-info pl-3 kirim rounded-3"
                                                    type="submit">kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 grid-margin">
                    <div class="card kanan scrollbar-dusty-grass square thin rounded-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="preview-list">
                                        <div class="preview-item">
                                            <div class="preview-item-content d-sm-flex flex-grow">
                                                <h3 class="fw-semibold mb-3" style="color: #957dad; margin-top: -30px;">Chat
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="chat" style="margin-top: -20px; position: relative">
                                            <form action="{{ route('message.project') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id_project" value="{{ $project[0]->id }}">
                                                <div class="card ">
                                                    <div style="height: 20px">
                                                        <div class="card-body" style="overflow-y: scroll; height: 70vh;">
                                                            <div style="display: flex; flex-direction: column;">
                                                                @foreach ($datas as $key => $item)
                                                                    @if ($key == 0 || $item->messages->name != $datas[$key - 1]->messages->name)
                                                                        <span
                                                                            style="font-size: 12px; margin-bottom: 3px; color: rgb(171, 171, 171)">{{ $item->messages->name }}</span>
                                                                    @endif
                                                                    <span class="mb-2"
                                                                        style="font-size: 14px; color: rgb(52, 52, 52); background-color: whitesmoke; max-width: 50%; border-radius: 15px; text-align: left; padding: 3px 10px">{{ $item->message }}</span>
                                                                @endforeach
                                                                {{-- @dd($datas) --}}
                                                            </div>
                                                            <div class="input-with-icon"  style="position: absolute; bottom: 0; left: 0; right: 0; padding: 10px; background-color: white;">
                                                                    <input type="text" class="form-control rounded-4"
                                                                        placeholder="ketik di sini untuk admin" name="message"
                                                                        required>
                                                                    <i class="mdi mdi-send mr-2"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
