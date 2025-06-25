<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Data Barang Masuk</title>

    <!-- Custom fonts and styles -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet" />
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
</head>
<body id="page-top">
    <div id="wrapper">
        @include('layouts.sidebar')


        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar', ['lowStockItems' => $lowStockItems])


                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Data Barang Masuk</h1>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <a href="{{ route('barang-masuk.create') }}" class="btn btn-primary mb-3">
                                <i class="fas fa-plus"></i> Tambah Barang Masuk
                            </a>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Transaksi</th>
                                            <th>Nama Barang</th>
                                            <th>Jenis Barang</th>
                                            <th>Nama Supplier</th>
                                            <th>Tanggal</th>
                                            <th>Jumlah Masuk</th>
                                            <th>Satuan</th>
                                            <th>Pengaturan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($barangMasuks as $index => $bm)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $bm->id }}</td>
                                            <td>{{ $bm->barang->nama_barang ?? '-' }}</td>
                                            <td>{{ $bm->barang->jenisBarang->nama_jenis ?? '-' }}</td>
                                            <td>{{ $bm->supplier->nama_supplier ?? '-' }}</td>
                                            <td>{{ $bm->tanggal_masuk ? \Carbon\Carbon::parse($bm->tanggal_masuk)->format('d-m-Y') : '-' }}</td>
                                            <td>{{ $bm->jumlah }}</td>
                                            <td>{{ $bm->barang->satuan ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('barang-masuk.edit', $bm->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('barang-masuk.destroy', $bm->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
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

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
</body>
</html>
