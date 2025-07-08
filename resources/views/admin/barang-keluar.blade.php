<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Data Barang Keluar</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Data Barang Keluar</h1>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <a href="{{ route('barang-keluar.create') }}" class="btn btn-primary mb-3">
                                <i class="fas fa-plus"></i> Tambah Barang Keluar
                            </a>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Transaksi</th>
                                            <th>Nama Barang</th>
                                            <th>Jenis Barang</th>
                                            <th>Jumlah Keluar</th>
                                            <th>Admin yang Melayani Pembeli</th>
                                            <th>Pembeli</th>
                                            <th>No Telpon</th>
                                            <th>Satuan</th>
                                            <th>Alamat Tujuan</th>
                                            <th>Tanggal Keluar</th>
                                            <th>Pengaturan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($barangKeluars as $index => $barangKeluar)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $barangKeluar->id }}</td>
                                            <td>{{ $barangKeluar->barang->nama_barang }}</td>
                                            <td>{{ $barangKeluar->barang->jenisBarang->nama_jenis ?? '-' }}</td>
                                            <td>{{ $barangKeluar->jumlah_keluar }}</td>
                                            <td>
                                                @if($barangKeluar->penjual == 1)
                                                    Admin 1
                                                @elseif($barangKeluar->penjual == 2)
                                                    Admin 2
                                                @elseif($barangKeluar->penjual == 3)
                                                    Admin 3
                                                @elseif($barangKeluar->penjual == 4)
                                                    Admin 4
                                                @elseif($barangKeluar->penjual == 5)
                                                    Admin 5
                                                @elseif($barangKeluar->penjual == 6)
                                                    Admin 6
                                                @else
                                                    Unknown
                                                @endif
                                            </td>
                                            <td>{{ $barangKeluar->pembeli }}</td>
                                            <td>{{ $barangKeluar->no_telp }}</td>
                                            <td>{{ $barangKeluar->barang->satuan ?? '-' }}</td>
                                            <td>{{ $barangKeluar->tujuan }}</td>
                                            <td>{{ $barangKeluar->tanggal_keluar ? \Carbon\Carbon::parse($barangKeluar->tanggal_keluar)->format('d-m-Y') : '-' }}</td>
                                            <td>
                                                <a href="{{ route('barang-keluar.edit', $barangKeluar->id) }}" class="btn btn-sm btn-primary">Edit</a>
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
