<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Edit Barang Keluar</title>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- FontAwesome, Bootstrap & Custom Styles -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet" />
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet" />
</head>

<body id="page-top">
    <div id="wrapper">
        @include('layouts.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar', ['lowStockItems' => $lowStockItems])

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Edit Barang Keluar</h1>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="{{ route('barang-keluar.update', $barangKeluar->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Pilih Barang -->
                                <div class="form-group">
                                    <label for="barang_id">Nama Barang</label>
                                    <select class="form-control @error('barang_id') is-invalid @enderror" id="barang_id" name="barang_id" required>
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach($barangs as $barang)
                                            <option 
                                                value="{{ $barang->id }}" 
                                                data-jenis="{{ $barang->jenisBarang->nama_jenis ?? '' }}" 
                                                data-satuan="{{ $barang->satuan ?? '' }}"
                                                {{ old('barang_id', $barangKeluar->barang_id) == $barang->id ? 'selected' : '' }}>{{ $barang->nama_barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('barang_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Jenis Barang (Tampil saja) -->
                                <div class="form-group">
                                    <label for="jenis_barang">Jenis Barang</label>
                                    <input type="text" id="jenis_barang" name="jenis_barang" class="form-control" value="{{ old('jenis_barang', $barangKeluar->barang->jenisBarang->nama_jenis ?? '') }}" readonly>
                                </div>

                                <!-- Satuan Barang (Tampil saja) -->
                                <div class="form-group">
                                    <label for="satuan">Satuan</label>
                                    <input type="text" id="satuan" name="satuan" class="form-control" value="{{ old('satuan', $barangKeluar->barang->satuan ?? '') }}" readonly>
                                </div>

                                <!-- Jumlah Barang Keluar -->
                                <div class="form-group">
                                    <label for="jumlah_keluar">Jumlah Keluar</label>
                                    <input type="number" class="form-control @error('jumlah_keluar') is-invalid @enderror" id="jumlah_keluar" name="jumlah_keluar" value="{{ old('jumlah_keluar', $barangKeluar->jumlah_keluar) }}" min="1" required>
                                    @error('jumlah_keluar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Admin (Penjual) -->
                                <div class="form-group">
                                    <label for="penjual">Admin</label>
                                    <select class="form-control @error('penjual') is-invalid @enderror" id="penjual" name="penjual" required>
                                        <option value="">-- Pilih Admin --</option>
                                        <option value="2" {{ old('penjual', $barangKeluar->penjual) == '2' ? 'selected' : '' }}>Admin 2</option>
                                        <option value="3" {{ old('penjual', $barangKeluar->penjual) == '3' ? 'selected' : '' }}>Admin 3</option>
                                        <option value="4" {{ old('penjual', $barangKeluar->penjual) == '4' ? 'selected' : '' }}>Admin 4</option>
                                        <option value="5" {{ old('penjual', $barangKeluar->penjual) == '5' ? 'selected' : '' }}>Admin 5</option>
                                        <option value="6" {{ old('penjual', $barangKeluar->penjual) == '6' ? 'selected' : '' }}>Admin 6</option>
                                    </select>
                                    @error('penjual')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Pembeli -->
                                <div class="form-group">
                                    <label for="pembeli">Pembeli</label>
                                    <input type="text" class="form-control @error('pembeli') is-invalid @enderror" id="pembeli" name="pembeli" value="{{ old('pembeli', $barangKeluar->pembeli) }}" required>
                                    @error('pembeli')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- No Telpon -->
                                <div class="form-group">
                                    <label for="no_telp">No Telpon</label>
                                    <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ old('no_telp', $barangKeluar->no_telp) }}" required>
                                    @error('no_telp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tujuan -->
                                <div class="form-group">
                                    <label for="tujuan">Alamat Tujuan</label>
                                    <input type="text" class="form-control @error('tujuan') is-invalid @enderror" id="tujuan" name="tujuan" value="{{ old('tujuan', $barangKeluar->tujuan) }}" required>
                                    @error('tujuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tanggal Keluar -->
                                <div class="form-group">
                                    <label for="tanggal_keluar">Tanggal Keluar</label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('tanggal_keluar') is-invalid @enderror" 
                                        id="tanggal_keluar" 
                                        name="tanggal_keluar" 
                                        value="{{ old('tanggal_keluar', \Carbon\Carbon::parse($barangKeluar->tanggal_keluar)->format('d-m-Y')) }}" 
                                        placeholder="dd-mm-yyyy" 
                                        readonly 
                                        required
                                    >
                                    @error('tanggal_keluar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit and Cancel -->
                                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary mt-3">Batal</a>
                            </form>
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

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set maxDate as today and minDate as 7 days ago
            const today = new Date();
            const last7Days = new Date();
            last7Days.setDate(today.getDate() - 7);

            // Initialize Flatpickr with the desired settings
            flatpickr("#tanggal_keluar", {
                dateFormat: "d-m-Y", // Set the format to dd-mm-yyyy
                minDate: last7Days, // Allow dates from 7 days ago
                maxDate: today,    // Allow dates up to today
                disableMobile: true, // Disable mobile datepicker
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const barangSelect = document.getElementById('barang_id');
            const jenisInput = document.getElementById('jenis_barang');
            const satuanInput = document.getElementById('satuan');

            function updateFields() {
                const selectedOption = barangSelect.options[barangSelect.selectedIndex];
                jenisInput.value = selectedOption.getAttribute('data-jenis') || '';
                satuanInput.value = selectedOption.getAttribute('data-satuan') || '';
            }

            // Inisialisasi jika sudah ada nilai lama (edit atau validasi gagal)
            updateFields();

            // Update setiap kali pilih barang berubah
            barangSelect.addEventListener('change', updateFields);
        });
    </script>

</body>
</html>
