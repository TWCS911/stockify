<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Activity Logs</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <style>
        .table-responsive {
            overflow-x: auto;  /* Menambahkan kemampuan scroll horizontal */
            -webkit-overflow-scrolling: touch; /* Menambahkan scroll yang lebih mulus di perangkat mobile */
        }

        td {
            word-wrap: break-word;
            white-space: pre-wrap;  /* Untuk menampilkan data panjang dalam format yang lebih baik */
            max-width: 200px; /* Atur lebar kolom jika diperlukan */
        }

        .table th, .table td {
            vertical-align: middle;
        }

        /* Optional: Mengubah ukuran font untuk data JSON agar lebih mudah dibaca */
        pre {
            font-size: 12px;
            white-space: pre-wrap;
            word-wrap: break-word;
            margin: 0;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        @include('pemilik.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('pemilik.navbar', ['lowStockItems' => $lowStockItems])

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Activity Logs</h1>

                    <!-- Success message -->
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Action</th>
                                            <th>Model</th>
                                            <th>Data</th>
                                            <th>User</th>
                                            <th>Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($logs as $index => $log)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $log->action }}</td>
                                            <td>{{ $log->model }}</td>
                                            <td>
                                                @if(is_array($log->data))
                                                    <pre>{{ json_encode($log->data, JSON_PRETTY_PRINT) }}</pre>
                                                @else
                                                    {{ $log->data }}
                                                @endif
                                            </td>
                                            <td>{{ $log->user->name }}</td>
                                            <td>{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
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

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
</body>

</html>
