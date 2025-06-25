<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Edit Barang</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet" />
</head>
<body id="page-top">
    <div id="wrapper">
        @include('layouts.sidebar')


        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar', ['lowStockItems' => $lowStockItems])


                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Edit Barang</h1>

                    <div class="card shadow mb-4">
                        <div class="card-body">

                            {{-- Tampilkan error validation --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('barang.update', $barang->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Nama Barang -->
                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input type="text" id="nama_barang" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" value="{{ old('nama_barang', $barang->nama_barang) }}" required />
                                    @error('nama_barang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Jenis Barang -->
                                <div class="form-group">
                                    <label for="jenis_barang_id">Jenis Barang</label>
                                    <select id="jenis_barang_id" name="jenis_barang_id" class="form-control @error('jenis_barang_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Jenis Barang --</option>
                                        @foreach ($jenisBarangs as $jenis)
                                            <option value="{{ $jenis->id }}" {{ old('jenis_barang_id', $barang->jenis_barang_id) == $jenis->id ? 'selected' : '' }}>
                                                {{ $jenis->nama_jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_barang_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Satuan Barang -->
                                <div class="form-group">
                                    <label for="satuan">Satuan Barang</label>
                                    <select id="satuan" name="satuan" class="form-control @error('satuan') is-invalid @enderror" required>
                                        <option value="">-- Pilih Satuan Barang --</option>
                                        @foreach ($satuanOptions as $option)
                                            <option value="{{ $option }}" {{ old('satuan', $barang->satuan) == $option ? 'selected' : '' }}>
                                                {{ ucfirst($option) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                <a href="{{ route('data-barang') }}" class="btn btn-secondary mt-3">Batal</a>
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
