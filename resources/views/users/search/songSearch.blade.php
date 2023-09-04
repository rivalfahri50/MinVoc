@extends('users.components.usersTemplates')

@section('content')
<link rel="stylesheet" href="/user/assets/css/songSearch.css">

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="row">
                    <div class="col-4">
                        <div class="card coba" style="display: flex;">
                            <div class="card-body" style="display: flex;">
                                <div class="cell-content">
                                    <img src="assets/images/faces/face1.jpg" alt="Face" class="avatar">
                                </div>
                                <div style="margin-left: 10px;">
                                    <h4 class="judul mt-4">Hati Hati Di Jalan</h4>
                                    <div class="d-flex flex-row align-content-center">
                                        <p class="text-muted m-1">Tulus</p>
                                        <a href="#" class="d-flex align-items-center d-block" style="height: 28px;">
                                            <i class="far fa-play-circle fa-2xl pl-2" style="font-size: 20px; display: none; color: #957DAD;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <hr class="divider"> <!-- Divider -->
            </div>
            <div class="col-md-12 grid-margin stretch-card">
                <h3 class="card-title judul">Lagu-lagu</h3>
                <div class="card scroll scrollbar-down thin">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="preview-list">
                                    <div class="preview-item">
                                        <div class="preview-thumbnail">
                                            <img src="../assets/images/faces/face1.jpg" width="10%">
                                        </div>
                                        <div class="preview-item-content d-sm-flex flex-grow">
                                            <div class="flex-grow">
                                                <h6 class="preview-subject">Tak Ingin Usai</h6>
                                                <p class="text-muted mb-0">Keisya</p>
                                            </div>
                                            <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                <div class="text-group">
                                                    <i onclick="myFunction(this)" class="far fa-heart pr-2">
                                                    </i>
                                                    <p>2.26</p>
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="preview-item">
                                        <div class="preview-thumbnail">
                                            <img src="../assets/images/faces/face1.jpg" width="10%">
                                        </div>
                                        <div class="preview-item-content d-sm-flex flex-grow">
                                            <div class="flex-grow">
                                                <h6 class="preview-subject">Tak Ingin Usai</h6>
                                                <p class="text-muted mb-0">Keisya</p>
                                            </div>
                                            <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                <div class="text-group">
                                                    <i onclick="myFunction(this)" class="far fa-heart pr-2">
                                                    </i>
                                                    <p>2.26</p>
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="preview-item">
                                        <div class="preview-thumbnail">
                                            <img src="../assets/images/faces/face1.jpg" width="10%">
                                        </div>
                                        <div class="preview-item-content d-sm-flex flex-grow">
                                            <div class="flex-grow">
                                                <h6 class="preview-subject">Tak Ingin Usai</h6>
                                                <p class="text-muted mb-0">Keisya</p>
                                            </div>
                                            <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                <div class="text-group">
                                                    <i onclick="myFunction(this)" class="far fa-heart pr-2">
                                                    </i>
                                                    <p>2.26</p>
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="preview-item">
                                        <div class="preview-thumbnail">
                                            <img src="../assets/images/faces/face1.jpg" width="10%">
                                        </div>
                                        <div class="preview-item-content d-sm-flex flex-grow">
                                            <div class="flex-grow">
                                                <h6 class="preview-subject">Tak Ingin Usai</h6>
                                                <p class="text-muted mb-0">Keisya</p>
                                            </div>
                                            <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                <div class="text-group">
                                                    <i onclick="myFunction(this)" class="far fa-heart pr-2">
                                                    </i>
                                                    <p>2.26</p>
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="preview-item">
                                        <div class="preview-thumbnail">
                                            <img src="../assets/images/faces/face1.jpg" width="10%">
                                        </div>
                                        <div class="preview-item-content d-sm-flex flex-grow">
                                            <div class="flex-grow">
                                                <h6 class="preview-subject">Tak Ingin Usai</h6>
                                                <p class="text-muted mb-0">Keisya</p>
                                            </div>
                                            <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                <div class="text-group">
                                                    <i onclick="myFunction(this)" class="far fa-heart pr-2">
                                                    </i>
                                                    <p>2.26</p>
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="preview-item">
                                        <div class="preview-thumbnail">
                                            <img src="../assets/images/faces/face1.jpg" width="10%">
                                        </div>
                                        <div class="preview-item-content d-sm-flex flex-grow">
                                            <div class="flex-grow">
                                                <h6 class="preview-subject">Tak Ingin Usai</h6>
                                                <p class="text-muted mb-0">Keisya</p>
                                            </div>
                                            <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                <div class="text-group">
                                                    <i onclick="myFunction(this)" class="far fa-heart pr-2">
                                                    </i>
                                                    <p>2.26</p>
                                                    <i class="fas fa-ellipsis-v"></i>
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
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    </div>

    @endSection