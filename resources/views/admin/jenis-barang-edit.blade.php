<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Jenis Barang</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        @include('layouts.sidebar')


        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar', ['lowStockItems' => $lowStockItems])


                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Edit Jenis Barang</h1>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="{{ route('jenis-barang.update', $jenisBarang->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="nama_jenis">Nama Jenis Barang</label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('nama_jenis') is-invalid @enderror" 
                                        id="nama_jenis" 
                                        name="nama_jenis" 
                                        value="{{ old('nama_jenis', $jenisBarang->nama_jenis) }}" 
                                        required 
                                        minlength="5" 
                                        pattern="^[a-zA-Z\s]+$" 
                                        title="Nama jenis barang hanya boleh mengandung huruf dan spasi.">

                                    @error('nama_jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Update</button>
                                <a href="{{ route('jenis-barang') }}" class="btn btn-secondary mt-3">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>
</html>
