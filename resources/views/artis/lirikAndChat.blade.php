@extends('artis.components.artisTemplate')

@section('content')
    <div class="main-panel">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
        </script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        <style>
            .note-editor.note-frame .note-editing-area {
                overflow: hidden;
                background-color: #ffffff;
            }

            .dropdown-toggle::after {
                content: none;
            }

            .input-with-icon {
                display: flex;
                align-items: center;
            }

            .form-control {
                flex: 1;
            }

            .send-button {
                background-color: #957dad;
                /* Warna latar belakang tombol */
                color: #fff;
                /* Warna teks tombol */
                border: none;
                padding: 5px 10px;
                border-radius: 4px;
                cursor: pointer;
            }

            .send-button:hover {
                background-color: #634582;
                /* Warna latar belakang tombol saat dihover */
            }

            .full-width-button {
                width: 100%;
            }
        </style>
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-7">
                    <div class="card kiri scrollbar-dusty-grass square thin rounded-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="preview-list">
                                        <form action="{{ route('create.project.artis') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="code" value="{{ $project->code }}">
                                            <div class="preview-item">
                                                <div class="preview-item-content d-sm-flex flex-grow">
                                                    <h3 class="fw-semibold" style="color: #957dad; margin-top: -30px;">
                                                        Project
                                                        {{ $project->name }}</h3>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" name="judul"
                                                    class="form-control form-i input-judul pl-3" id="namaproyek"
                                                    placeholder="Judul Lagu" style="background-color: #ffffff" required>
                                            </div>
                                            <textarea name="lirik" id="summernote" style="background-color: #ffffff; border: 1px solid #6d6d6d"></textarea>
                                            <script>
                                                $('#summernote').summernote({
                                                    placeholder: 'Teks',
                                                    tabsize: 2,
                                                    height: 250,
                                                    toolbar: [
                                                        ['style', ['style']],
                                                        ['font', ['bold', 'underline', 'clear']],
                                                        ['color', ['color']],
                                                        ['para', ['paragraph']],
                                                        ['view', ['codeview']]
                                                    ]
                                                });
                                            </script>
                                            <div class="mt-3">
                                                <button class="btn pl-3 kirim rounded-3 full-width-button"
                                                    type="submit">kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    /* CSS untuk chat box */
                    .chat-box {
                        overflow-y: scroll;
                        height: 70vh;
                        background-color: white;
                        border-radius: 10px;
                        border: 1px solid rgba(0, 0, 0, 0.2);
                        padding: 10px;
                    }

                    /* CSS untuk pesan chat */
                    .chat-message {
                        display: flex;
                        flex-direction: column;
                        align-items: flex-start;
                        margin-bottom: 10px;
                    }

                    .chat-name {
                        font-size: 12px;
                        color: rgb(171, 171, 171);
                        text-align: right;
                    }

                    .chat-text {
                        font-size: 14px;
                        color: rgb(52, 52, 52);
                        background-color: whitesmoke;
                        max-width: 50%;
                        border-radius: 15px;
                        padding: 8px 15px;
                    }

                    /* CSS untuk input chat */
                    .chat-input {
                        position: absolute;
                        bottom: 0;
                        left: 0;
                        right: 10px;
                        padding: 10px;
                        display: flex;
                        align-items: center;
                        background-color: white;
                        background-color: white;
                        border-radius: 10px;
                        border: 1px solid #c9c9c9;
                    }
                </style>
                <div class="col-md-5">
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
                                                <input type="hidden" name="id_project" value="{{ $project->id }}">
                                                <div class="card">
                                                    <div style="height: 415px">
                                                        <div class="card-body chat-box">
                                                            @foreach ($datas as $key => $item)
                                                                <div class="chat-message">
                                                                    @if ($key == 0 || $item->messages->name != $datas[$key - 1]->messages->name)
                                                                        <div class="chat-name">{{ $item->messages->name }}
                                                                        </div>
                                                                    @endif
                                                                    <div class="chat-text">{{ $item->message }}</div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="input-with-icon chat-input">
                                                            <input type="text" class="form-control rounded-4"
                                                                placeholder="Ketik di sini untuk admin" name="message">
                                                            <button type="submit" class="send-button ml-2 mr-1">
                                                                <i class="fas fa-paper-plane"></i>
                                                            </button>
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
