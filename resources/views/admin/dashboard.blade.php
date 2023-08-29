<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        .box {
            box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
        }
    </style>
</head>

<body>

    <section class="vh-100" style="background-color: whitesmoke;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong box" style="border-radius: 1rem;">
                        <div class="card-body p-5">
                            <form action="{{ route('createProject.admin') }}" method="POST">
                                @csrf
                                <h3 class="mb-5 text-center">Sign Up</h3>

                                @if (session()->has('message'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('message') }}
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul Projects</label>
                                    <input type="text" class="form-control" id="judul" name="judul">
                                    @error('judul')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="judul" class="form-label">Genre</label>
                                    <select class="form-select" name="genre" aria-label="Default select example">
                                        <option selected value="pop">Pop</option>
                                    </select>
                                    @error('genre')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="konsep" class="form-label">Konsep</label>
                                    <textarea class="form-control" name="konsep" id="konsep" rows="3"></textarea>
                                    @error('konsep')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" class="form-control" id="harga" name="harga">
                                    @error('harga')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="d-flex flex-column gap-3">
                                    <span>
                                        sudah punya akun? <a href="/">login</a>
                                    </span>
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Daftar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
