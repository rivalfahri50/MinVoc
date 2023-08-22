@extends('artis.components.artisTemplate')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
          <div class="card kiri scrollbar-dusty-grass square thin">
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <div class="preview-list">
                    <div class="preview-item">
                      <div class="preview-item-content d-sm-flex flex-grow">
                        <h3 class="fw-semibold" style="color: #957dad; margin-top: -30px;">Judul Lagu</h3>
                      </div>
                    </div>
                    <div class="mb-3" style="margin-top: -20px;">
                      <input type="email" class="input-judul pl-3" id="exampleFormControlInput1" placeholder="ketik di sini">
                    </div>
                    <div class="mb-3">
                      <textarea class="input-judul summernote" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <div class="mb-3" style="margin-top: 5px;">
                      <button class="btn btn-info pl-3 kirim rounded-3">kirim</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5 grid-margin">
          <div class="card kanan scrollbar-dusty-grass square thin">
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <div class="preview-list">
                    <div class="preview-item">
                      <div class="preview-item-content d-sm-flex flex-grow">
                        <h3 class="fw-semibold mb-3" style="color: #957dad; margin-top: -30px;">Chat</h3>
                      </div>
                    </div>
                    <div class="chat" style="margin-top: -20px;">
                      <div class="card">
                        <div class="card-body">
                          <div class="input-with-icon">
                            <input type="text" class="form-control rounded-4" placeholder="ketik di sini">
                              <i class="mdi mdi-send"></i>
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
    </div>
  </div>
@endsection
