<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Tambah Barang Masuk</title>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- FontAwesome, Bootstrap & Custom Styles -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet" />
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet" />

    <!-- Load Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body id="page-top">
    <div id="wrapper">
        @include('layouts.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar', ['lowStockItems' => $lowStockItems])

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Tambah Barang Masuk</h1>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="{{ route('barang-masuk.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="barang_id">Nama Barang</label>
                                    <select class="form-control @error('barang_id') is-invalid @enderror" id="barang_id" name="barang_id" required>
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach($barangs as $barang)
                                            <option 
                                                value="{{ $barang->id }}" 
                                                data-jenis="{{ $barang->jenisBarang->nama_jenis ?? '' }}" 
                                                data-satuan="{{ $barang->satuan ?? '' }}" 
                                                {{ old('barang_id') == $barang->id ? 'selected' : '' }}>{{ $barang->nama_barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('barang_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="jenis_barang">Jenis Barang</label>
                                    <input type="text" id="jenis_barang" name="jenis_barang" class="form-control" value="{{ old('jenis_barang', $barangMasuk->barang->jenisBarang->nama_jenis ?? '') }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="satuan">Satuan</label>
                                    <input type="text" id="satuan" name="satuan" class="form-control" value="{{ old('satuan', $barangMasuk->barang->satuan ?? '') }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="supplier_id">Nama Supplier</label>
                                    <select class="form-control @error('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id" required>
                                        <option value="">-- Pilih Supplier --</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id_supplier }}" {{ old('supplier_id') == $supplier->id_supplier ? 'selected' : '' }}>{{ $supplier->nama_supplier }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="jumlah">Jumlah Masuk</label>
                                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1" required>
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tanggal Masuk -->
                                <div class="form-group">
                                    <label for="tanggal_masuk">Tanggal Masuk</label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('tanggal_masuk') is-invalid @enderror" 
                                        id="tanggal_masuk" 
                                        name="tanggal_masuk" 
                                        value="{{ old('tanggal_masuk') }}" 
                                        placeholder="dd/mm/yyyy" 
                                        readonly 
                                        required
                                    >
                                    @error('tanggal_masuk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary mt-3">Batal</a>
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
            flatpickr("#tanggal_masuk", {
                dateFormat: "d/m/Y", // Set the format to dd/mm/yyyy
                minDate: last7Days, // Allow dates from 7 days ago
                maxDate: today,    // Allow dates up to today
                disableMobile: true, // Disable mobile datepicker
                onChange: function(selectedDates) {
                    // Set the selected date value into the input field
                    document.getElementById('tanggal_masuk').value = selectedDates[0].toLocaleDateString("en-GB");
                }
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
