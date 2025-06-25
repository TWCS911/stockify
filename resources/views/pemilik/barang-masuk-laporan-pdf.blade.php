<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Masuk - {{ $bulan }}/{{ $tahun }}</title>
</head>
<body>
    <h1>Laporan Barang Masuk</h1>
    <h2>Bulan: {{ $bulan }} Tahun: {{ $tahun }}</h2>

    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Supplier</th>
                <th>Jumlah</th>
                <th>Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangMasuks as $index => $barangMasuk)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $barangMasuk->barang->nama_barang }}</td>
                    <td>{{ $barangMasuk->supplier->nama_supplier }}</td>
                    <td>{{ $barangMasuk->jumlah }}</td>
                    <td>{{ $barangMasuk->tanggal_masuk ? \Carbon\Carbon::parse($barangMasuk->tanggal_masuk)->format('d-m-Y') : '-' }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
