<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        @include('pemilik.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('pemilik.navbar')

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Laporan Barang</h1>
                    
                    <!-- Form Pilih Jenis Laporan, Bulan dan Tahun -->
                    <form action="{{ route('barang.laporan.generate') }}" method="GET">
                        <div class="form-group">
                            <label for="jenis_laporan">Pilih Jenis Laporan</label>
                            <select class="form-control" id="jenis_laporan" name="jenis_laporan" required>
                                <option value="barang-masuk">Laporan Barang Masuk</option>
                                <option value="barang-keluar">Laporan Barang Keluar</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="bulan">Pilih Bulan</label>
                            <select class="form-control" id="bulan" name="bulan" required>
                                <option value="">-- Pilih Bulan --</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tahun">Pilih Tahun</label>
                            <input type="number" class="form-control" id="tahun" name="tahun" value="{{ date('Y') }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Generate Laporan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>
</html>
