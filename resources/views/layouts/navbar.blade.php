<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
</button>

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

    <!-- resources/views/admin/navbar.blade.php -->
    <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <!-- Counter - Alerts -->
            @php
                // Menghitung jumlah peringatan
                $lowStockItemsCount = count($lowStockItems);
                $outOfStockItemsCount = count($outOfStockItems);
            @endphp

            @if($lowStockItemsCount > 0 || $outOfStockItemsCount > 0)
                <span class="badge badge-danger badge-counter">{{ $lowStockItemsCount + $outOfStockItemsCount }}+</span>
            @else
                <span class="badge badge-danger badge-counter" style="visibility: hidden;">0</span>
            @endif
        </a>
        <!-- Dropdown - Alerts -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">
                Alerts Center
            </h6>

            <!-- Peringatan stok menipis -->
            @foreach($lowStockItems as $item)
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">{{ $item->nama_barang }}</div>
                        <span class="font-weight-bold">Stok barang menipis, sekarang hanya tersisa {{ $item->jumlah }}!</span>
                    </div>
                </a>
            @endforeach

            <!-- Peringatan stok habis -->
            @foreach($outOfStockItems as $item)
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-danger">
                            <i class="fas fa-times text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">{{ $item->nama_barang }}</div>
                        <span class="font-weight-bold">Stok barang habis!</span>
                    </div>
                </a>
            @endforeach

            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
        </div>
    </li>




    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ Auth::user()->name }}
                </span>
                <img class="img-profile rounded-circle"
                    src="{{ asset('img/undraw_profile.svg') }}">
        </a>

        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="userDropdown">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </form>
        </div>
    </li>

</ul>

</nav>
<!-- End of Topbar -->