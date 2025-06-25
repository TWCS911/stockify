<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Keluar - {{ $bulan }}/{{ $tahun }}</title>
</head>
<body>
    <h1>Laporan Barang Keluar</h1>
    <h2>Bulan: {{ $bulan }} Tahun: {{ $tahun }}</h2>

    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Penjual</th>
                <th>Pembeli</th>
                <th>Jumlah Keluar</th>
                <th>No Telp</th>
                <th>Tujuan</th>
                <th>Tanggal Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangKeluars as $index => $barangKeluar)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $barangKeluar->barang->nama_barang }}</td>
                    <td>{{ $barangKeluar->penjual }}</td>
                    <td>{{ $barangKeluar->pembeli }}</td>
                    <td>{{ $barangKeluar->jumlah_keluar }}</td>
                    <td>{{ $barangKeluar->no_telp }}</td>
                    <td>{{ $barangKeluar->tujuan }}</td>
                    <td>{{ $barangKeluar->tanggal_keluar ? \Carbon\Carbon::parse($barangKeluar->tanggal_keluar)->format('d-m-Y') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
