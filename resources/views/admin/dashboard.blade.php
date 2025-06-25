<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Pengelola Stok</title>
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
</head>
<body id="page-top">
    <div id="wrapper">

        @include('layouts.sidebar')
 <!-- Sidebar navigation -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar', ['lowStockItems' => $lowStockItems])
 <!-- Navbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard Pengelola Stok</h1>
                    </div>

                    <!-- Dashboard Stats -->
                    <div class="row">
                        <!-- Total Stok Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Stok Barang</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStok }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-cogs fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Barang Masuk Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Barang Masuk</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $barangMasuk }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Barang Keluar Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Barang Keluar</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $barangKeluar }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Log Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Aktivitas Pengguna</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activityLogs }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-history fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Bar Chart -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <canvas id="barChart" width="300" height="150"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Line Chart -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <canvas id="lineChart" width="300" height="150"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    barangmasuk = {{ $barangMasuk }};
    <!-- End of Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Mengambil data menggunakan AJAX
            $.ajax({
                url: '/api/dashboard-data',  // Endpoint API yang kita buat
                type: 'GET',  // Method GET untuk mengambil data
                success: function(response) {
                    // Ambil data dari response JSON
                    const totalStok = response.totalStok;
                    const barangMasuk = response.barangMasuk;
                    const barangKeluar = response.barangKeluar;
                    const activityLogs = response.activityLogs;

                    // Inisialisasi chart setelah menerima data
                    const ctxBar = document.getElementById('barChart').getContext('2d');
                    const barChart = new Chart(ctxBar, {
                        type: 'bar',
                        data: {
                            labels: ['Total Stok Barang', 'Barang Masuk', 'Barang Keluar', 'Aktivitas Pengguna'],
                            datasets: [{
                                label: 'Jumlah',
                                data: [totalStok, barangMasuk, barangKeluar, activityLogs],  // Menggunakan data yang diterima
                                backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e', '#36b9cc'],
                                borderColor: ['#4e73df', '#1cc88a', '#f6c23e', '#36b9cc'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    </script>


    <script>
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        const lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],  // Gantilah dengan data bulan yang sesuai
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: [10, 20, 15, 25, 30],  // Gantilah dengan data yang sesuai
                        borderColor: '#1cc88a',
                        fill: false
                    },
                    {
                        label: 'Barang Keluar',
                        data: [5, 10, 12, 15, 18],  // Gantilah dengan data yang sesuai
                        borderColor: '#f6c23e',
                        fill: false
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Pastikan ini sudah ada di bagian <head> atau sebelum script lainnya -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js?v={{ time() }}"></script>


    <script>
        $(document).ready(function() {
            let lineChart = null;

            // Mengambil data menggunakan AJAX
            $.ajax({
                url: '/api/dashboard-data',  // Endpoint API yang kita buat
                type: 'GET',  // Method GET untuk mengambil data
                success: function(response) {
                    // Ambil data barang masuk dan barang keluar per bulan
                    const barangMasukPerBulan = response.barangMasukPerBulan;
                    const barangKeluarPerBulan = response.barangKeluarPerBulan;

                    // Format data untuk digunakan di chart
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    const barangMasukData = [];
                    const barangKeluarData = [];

                    // Isikan data barang masuk dan barang keluar sesuai bulan
                    for (let i = 1; i <= 12; i++) {
                        barangMasukData.push(barangMasukPerBulan[i] || 0);  // Jika tidak ada data, set 0
                        barangKeluarData.push(barangKeluarPerBulan[i] || 0);  // Jika tidak ada data, set 0
                    }

                    // Hapus chart yang lama jika ada
                    if (lineChart) {
                        lineChart.destroy();
                    }

                    // Inisialisasi line chart
                    const ctxLine = document.getElementById('lineChart').getContext('2d');
                    lineChart = new Chart(ctxLine, {
                        type: 'line',
                        data: {
                            labels: months,  // Label bulan
                            datasets: [
                                {
                                    label: 'Barang Masuk',
                                    data: barangMasukData,  // Data yang diterima dari AJAX
                                    borderColor: '#1cc88a',
                                    fill: false
                                },
                                {
                                    label: 'Barang Keluar',
                                    data: barangKeluarData,  // Data yang diterima dari AJAX
                                    borderColor: '#f6c23e',
                                    fill: false
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    </script>

</body>
</html>
