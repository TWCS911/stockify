<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Edit Supplier</title>

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
                    <h1 class="h3 mb-4 text-gray-800">Edit Supplier</h1>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="{{ route('suppliers.update', $supplier->id_supplier) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="nama_supplier">Nama Supplier</label>
                                    <input 
                                        type="text" 
                                        id="nama_supplier" 
                                        name="nama_supplier" 
                                        class="form-control @error('nama_supplier') is-invalid @enderror" 
                                        value="{{ old('nama_supplier', $supplier->nama_supplier) }}" 
                                        required 
                                        pattern="^(?=.*[a-zA-Z])[a-zA-Z0-9\s]+$" 
                                        title="Nama supplier harus mengandung huruf dan bisa menggunakan angka." 
                                        minlength="3">
                                    @error('nama_supplier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="alamat_supplier">Alamat Supplier</label>
                                    <textarea 
                                        id="alamat_supplier" 
                                        name="alamat_supplier" 
                                        class="form-control @error('alamat_supplier') is-invalid @enderror" 
                                        required 
                                        minlength="10" 
                                        pattern="^(?=.*[a-zA-Z])[a-zA-Z0-9\s]+$" 
                                        title="Alamat harus mengandung huruf dan boleh menggunakan angka." 
                                    >{{ old('alamat_supplier', $supplier->alamat_supplier) }}</textarea>
                                    @error('alamat_supplier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="no_telp_supplier">No. Telp Supplier</label>
                                    <input 
                                        type="text" 
                                        id="no_telp_supplier" 
                                        name="no_telp_supplier" 
                                        class="form-control @error('no_telp_supplier') is-invalid @enderror" 
                                        value="{{ old('no_telp_supplier', $supplier->no_telp_supplier) }}" 
                                        required 
                                        minlength="10" 
                                        pattern="^[0-9]+$" 
                                        title="Nomor telepon hanya boleh mengandung angka.">
                                    @error('no_telp_supplier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Update</button>
                                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary mt-3">Batal</a>
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
