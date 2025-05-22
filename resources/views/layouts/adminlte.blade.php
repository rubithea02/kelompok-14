<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Website Pendataan Assets</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ url('/') }}" class="nav-link">Home</a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link">
                <span class="brand-text font-weight-light">Pendataan Assets</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    {{-- filepath: resources/views/layouts/adminlte.blade.php --}}
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item">
                            <a href="{{ url('/dashboard') }}"
                                class="nav-link {{ request()->is('/') || request()->is('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/pengguna') }}"
                                class="nav-link {{ request()->is('pengguna') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Daftar Pengguna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/aset') }}" class="nav-link {{ request()->is('aset') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>Daftar Aset</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/gudang') }}"
                                class="nav-link {{ request()->is('gudang') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-warehouse"></i>
                                <p>Daftar Gudang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/transaksi') }}"
                                class="nav-link {{ request()->is('transaksi') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-exchange-alt"></i>
                                <p>Transaksi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/peminjaman') }}"
                                class="nav-link {{ request()->is('peminjaman') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-hand-holding"></i>
                                <p>Peminjaman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/pengembalian') }}"
                                class="nav-link {{ request()->is('pengembalian') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-undo"></i>
                                <p>Pengembalian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/perbaikan') }}"
                                class="nav-link {{ request()->is('perbaikan') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>Perbaikan Asset</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 100vh;">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- AdminLTE JS -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
</body>

</html>