        <!-- Logo Header -->
        <div class="main-header">
            <div class="logo-header" data-background-color="blue">

                <a href="{{ route('dashboard') }}" class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="logo edp" width="100%" height="100%">
                </a>

                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>

                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

                <div class="container-fluid">

                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">


                        {{-- Untuk Admin --}}
                        @can('isAdmin')
                            <li class="nav-item dropdown hidden-caret">
                                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="notification">
                                        {{ $hard_req_progress + $hard_fix_progress + $soft_req_progress }} </span>
                                    <i class="fa fa-bell"></i>
                                    Notification
                                </a>
                                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                                    <li>
                                        <div class="dropdown-title">You have
                                            {{ $hard_req_progress + $hard_fix_progress + $soft_req_progress }} new
                                            notification</div>
                                    </li>
                                    <li>
                                        <div class="notif-scroll scrollbar-outer">
                                            <div class="notif-center">
                                                <a href="{{ route('hard_req_index') }}" class="notif-hover">
                                                    <div class="notif-icon notif-primary"> <i class="fas fa-archive"></i>
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block">
                                                            You have {{ $hard_req_progress }} of Hardware request in
                                                            progress
                                                        </span>
                                                        {{-- <span class="time">5 minutes ago</span> --}}
                                                    </div>
                                                </a>
                                                <a href="{{ route('hard_fix_index') }}" class="notif-hover">
                                                    <div class="notif-icon notif-success"> <i class="fas fa-archive"></i>
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block">
                                                            You have {{ $hard_fix_progress }} of Hardware fix in progress
                                                        </span>
                                                        {{-- <span class="time">12 minutes ago</span> --}}
                                                    </div>
                                                </a>

                                                <a href="{{ route('soft_req_index') }}" class="notif-hover">
                                                    <div class="notif-icon notif-danger"> <i class="fab fa-accusoft"></i>
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block">
                                                            You have {{ $soft_req_progress }} Software request in progress
                                                        </span>
                                                        {{-- <span class="time">17 minutes ago</span> --}}
                                                    </div>
                                                </a>
                                                <a href="{{ route('request') }}" class="notif-hover">
                                                    <div class="notif-icon notif-success"> <i
                                                            class="fas fa-exclamation"></i>
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block">
                                                            See all request
                                                        </span>
                                                        {{-- <span class="time">17 minutes ago</span> --}}
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('ticket-create') }}">
                                <i class="fas fa-ticket-alt"></i>
                                <span>
                                    New Ticket
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('procurement_index') }}">
                                <i class="fas fa-ticket-alt"></i>
                                <span>
                                    PPB Track
                                </span>
                            </a>
                        </li>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="fas fa-box"></i>
                                General Affair
                            </a>
                            <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                                <div class="quick-actions-header">
                                    <span class="title mb-1">Permintaan ATK</span>
                                    <span class="subtitle op-8">Shortcuts</span>
                                </div>
                                <div class="quick-actions-scroll scrollbar-outer">
                                    <div class="quick-actions-items">
                                        <div class="row m-0">
                                            @can('isGA')
                                                <a class="col-6 col-md-6 p-0"href="{{ route('ga.masterItem') }}">
                                                    <div class="quick-actions-item notif-hover">
                                                        <i class="flaticon-database"></i>
                                                        <span class="text">Daftar Barang</span>
                                                    </div>
                                                </a>
                                                <a class="col-6 col-md-6 p-0" href="{{ route('ga.masterWarehouse') }}">
                                                    <div class="quick-actions-item notif-hover">
                                                        <i class="flaticon-pen"></i>
                                                        <span class="text">Daftar Gudang</span>
                                                    </div>
                                                </a>
                                            @endcan
                                            <a class="col-6 col-md-6 p-0"
                                                accesskey="f"href="{{ route('ga.ItemWarehouse') }}">
                                                <div class="quick-actions-item notif-hover">
                                                    <i class="flaticon-interface-1"></i>
                                                    <span class="text">Stok Barang</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-6 p-0"
                                                accesskey="f"href="{{ route('ga.reportIndex') }}">
                                                <div class="quick-actions-item notif-hover">
                                                    <i class="flaticon-interface-1"></i>
                                                    <span class="text">Report Permintaan Barang</span>
                                                </div>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="fas fa-layer-group"></i>
                                Request
                            </a>
                            <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                                <div class="quick-actions-header">
                                    <span class="title mb-1">Quick Actions</span>
                                    <span class="subtitle op-8">Shortcuts</span>
                                </div>
                                <div class="quick-actions-scroll scrollbar-outer">
                                    <div class="quick-actions-items">
                                        <div class="row m-0">
                                            <a
                                                class="col-6 col-md-6 p-0"accesskey="s"href="{{ route('soft_req_create') }}">
                                                <div class="quick-actions-item notif-hover">
                                                    <i class="flaticon-database"></i>
                                                    <span class="text">Pengadaan Software<br> (Alt + S)</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-6 p-0" accesskey="h"
                                                href="{{ route('hard_req_create') }}">
                                                <div class="quick-actions-item notif-hover">
                                                    <i class="flaticon-pen"></i>
                                                    <span class="text">Pengadaan Hardware<br> (Alt + H)</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-6 p-0"
                                                accesskey="f"href="{{ route('hard_fix_create') }}">
                                                <div class="quick-actions-item notif-hover">
                                                    <i class="flaticon-interface-1"></i>
                                                    <span class="text">Perbaikan Hardware <br>(Alt + Shift +
                                                        F)</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-6 p-0"
                                                accesskey="t"href="{{ route('ink_index') }}">
                                                <div class="quick-actions-item notif-hover">
                                                    <i class="flaticon-list"></i>
                                                    <span class="text">Permintaan Tinta <br>(Alt + T)</span>
                                                </div>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="far fa-user-circle"></i>
                                {{ Auth::user()->name }}

                            </a>

                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="u-text">
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();this.closest('form').submit();">Log
                                                        out</a>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="user-box">
                                            <div class="u-text">
                                                <a class="dropdown-item"
                                                    href="{{ route('users.view', Auth::user()->id) }}">My Profile</a>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                            </ul>

                        </li>

                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">

                    <ul class="nav nav-primary">
                        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Request</h4>
                        </li>
                        <li class="nav-item {{ Request::is('*/request') ? 'active' : '' }}">
                            <a href="{{ route('request') }}">
                                <i class="flaticon-agenda-1"></i>
                                <p>Request List</p>

                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('*/request_ink*') ? 'active' : '' }}">
                            <a href="{{ route('request_ink') }}">
                                {{-- <i class="flaticon-agenda-1"></i> --}}
                                <i class="fas fa-filter"></i>
                                <p>Request Ink List</p>

                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('*/ticket*') ? 'active' : '' }}">
                            <a href="{{ route('ticket') }}">
                                {{-- <i class="flaticon-agenda-1"></i> --}}
                                <i class="fas fa-ticket-alt"></i>
                                <p>Ticket List</p>

                            </a>
                        </li>
                        @can('isAdmin')


                            <li class="nav-section">
                                <span class="sidebar-mini-icon">
                                    <i class="fa fa-ellipsis-h"></i>
                                </span>
                                <h4 class="text-section">Components</h4>
                            </li>
                            <li class="nav-item {{ Request::is('*/hardware/*') ? 'active' : '' }}">
                                <a data-toggle="collapse" href="#base">
                                    <i class="fas fa-archive"></i>
                                    <p>Hardware</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="base">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="{{ route('hard_req_index') }}">
                                                <span class="sub-item">List Pengadaan Hardware</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('hard_req_create') }}">
                                                <span class="sub-item">Pengadaan Hardware</span>
                                            </a>
                                        </li>
                                        @can('isAdmin')
                                            <li>
                                                <a href="{{ route('template_index') }}">
                                                    <span class="sub-item">Template Index</span>
                                                </a>
                                            </li>
                                        @endcan
                                        <li>
                                            <a href="{{ route('hard_fix_index') }}">
                                                <span class="sub-item">List Perbaikan</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('hard_fix_create') }}">
                                                <span class="sub-item">Perbaikan</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item {{ Request::is('*/software/*') ? 'active' : '' }}">
                                <a data-toggle="collapse" href="#software">
                                    <i class="fab fa-accusoft"></i>
                                    <p>Software</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="software">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="{{ route('soft_req_create') }}">
                                                <span class="sub-item">Permintaan Software</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('soft_req_index') }}">
                                                <span class="sub-item">List Permintaan Software</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item {{ Request::is('*/ink*') ? 'active' : '' }}">
                                <a data-toggle="collapse" href="#tinta">
                                    <i class="fas fa-fill-drip"></i>
                                    <p>Tinta</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="tinta">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="{{ route('ink_index') }}">
                                                <span class="sub-item">List Tinta</span>
                                            </a>
                                        </li>
                                        @can('isAdmin')
                                            <li>
                                                <a href="{{ route('ink_create') }}">
                                                    <span class="sub-item">Tambah Jenis Tinta Baru</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('ink_report') }}">
                                                    <span class="sub-item">Report Tinta</span>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>
                        @endcan
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Inventaris</h4>
                        </li>
                        <li class="nav-item {{ Request::is('*/pc*') ? 'active' : '' }}">
                            <a data-toggle="collapse" href="#pc">
                                <i class="fas fa-layer-group"></i>
                                <p>PC</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="pc">
                                <ul class="nav nav-collapse">
                                    @can('isAdmin')
                                        <li>
                                            <a href="{{ route('pc_create') }}">
                                                <span class="sub-item">Tambah PC</span>
                                            </a>
                                        </li>
                                    @endcan
                                    <li>
                                        <a href="{{ route('pc_index') }}">
                                            <span class="sub-item">List PC</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('perawatan.pc.index') }}">
                                            <span class="sub-item">Perawatan</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <li class="nav-item {{ Request::is('*/monitor*') ? 'active' : '' }}">
                            <a data-toggle="collapse" href="#monitor">
                                <i class="fas fa-tv"></i>
                                <p>Monitor</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="monitor">
                                <ul class="nav nav-collapse">
                                    @can('isAdmin')
                                        <li>
                                            <a href="{{ route('monitor_create') }}">
                                                <span class="sub-item">Tambah Monitor</span>
                                            </a>
                                        </li>
                                    @endcan
                                    <li>
                                        <a href="{{ route('monitor_index') }}">
                                            <span class="sub-item">List Monitor</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <li class="nav-item  {{ Request::is('*/laptop*') ? 'active' : '' }}">
                            <a data-toggle="collapse" href="#laptop">
                                <i class="fas fa-laptop"></i>
                                <p>Laptop</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="laptop">
                                <ul class="nav nav-collapse">
                                    @can('isAdmin')
                                        <li>
                                            <a href="{{ route('laptop_create') }}">
                                                <span class="sub-item">Tambah Laptop</span>
                                            </a>
                                        </li>
                                    @endcan
                                    <li>
                                        <a href="{{ route('laptop_index') }}">
                                            <span class="sub-item">List laptop</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <li class="nav-item  {{ Request::is('*/printer*') ? 'active' : '' }}">
                            <a data-toggle="collapse" href="#printer">
                                <i class="fas fa-print"></i>
                                <p>Printer</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="printer">
                                <ul class="nav nav-collapse">
                                    @can('isAdmin')
                                        <li>
                                            <a href="{{ route('printer_create') }}">
                                                <span class="sub-item">Tambah Printer</span>
                                            </a>
                                        </li>
                                    @endcan
                                    <li>
                                        <a href="{{ route('printer_index') }}">
                                            <span class="sub-item">List Printer</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        @can('isAdmin')
                            <li class="nav-section">
                                <span class="sidebar-mini-icon">
                                    <i class="fa fa-ellipsis-h"></i>
                                </span>
                                <h4 class="text-section">User</h4>
                            </li>

                            <li class="nav-item {{ Request::is('*/users/*') ? 'active' : '' }}">
                                <a href="{{ route('users.index') }}">
                                    <i class="fas fa-id-card"></i>
                                    <p>User</p>
                                </a>
                            </li>
                            <li class="nav-item {{ Request::is('*/karyawan/*') ? 'active' : '' }}">
                                <a href="{{ route('karyawan_index') }}">
                                    <i class="fas fa-id-card"></i>
                                    <p>Karyawan</p>
                                </a>
                            </li>
                            <li class="nav-item {{ Request::is('*/divisi/*') ? 'active' : '' }}">
                                <a href="{{ route('divisi.index') }}">
                                    <i class="fas fa-user-friends"></i>
                                    <p>Divisi</p>
                                </a>
                            </li>
                            <li class="nav-item {{ Request::is('*/lokasi/*') ? 'active' : '' }}">
                                <a href="{{ route('lokasi.index') }}">
                                    <i class="fas fa-user-friends"></i>
                                    <p>Lokasi</p>
                                </a>
                            </li>
                        @endcan

                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Produksi</h4>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('pn_00_panel_display') }}">
                                {{-- <a href="{{ route('produksi_index') }}"> --}}
                                <i class="fas fa-tv"></i>
                                <p>View</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('*/panel/*') ? 'active' : '' }}">
                            {{-- <a href="{{ route('pro_index_panel') }}"> --}}
                            <a href="{{ route('pn_00_panel') }}">
                                <i class="fas fa-list"></i>
                                <p>Panel</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
