<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Penjual | {{ env('APP_NAME') }}</title>

    <!-- Google Font -->
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @yield('css')
</head>

<body class="hold-transition skin-purple sidebar-mini">
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="index2.html" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>ADM</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Penjual</b> {{ env('APP_NAME') }}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{{ asset('images/avatar_default.png') }}" class="user-image" alt="User Image">
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="{{ asset('images/avatar_default.png') }}" class="img-circle" alt="User Image">

                                    <p>
                                        {{ Auth::user()->name }} - Penjual
                                        <small>{{ Auth::user()->roles[0]->display_name }} Sejak {{ date_format(Auth::user()->created_at, 'M. Y') }}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{ route('seller.profile.index') }}" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ route('logout') }}" class="btn btn-default btn-flat"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Keluar
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ asset('images/avatar_default.png') }}" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>{{ Auth::user()->name }}</p>
                        <!-- Status -->
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @if ( Auth::user()->seller != null && Auth::user()->seller->status == "approve")
                        <li class="{{(Request::segment(2) == '') ? "active" : ""}}">
                            <a href="{{ route('seller.index') }}">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="{{(Request::segment(2) == 'bank') ? "active" : ""}}">
                            <a href="{{ route('seller.bank.index') }}">
                                <i class="fa fa-list"></i> <span>Bank</span>
                            </a>
                        </li>
                        <li class="{{(Request::segment(2) == 'customer') ? "active" : ""}}">
                            <a href="{{ route('seller.customer.index') }}">
                                <i class="fa fa-list"></i> <span>Pelanggan</span>
                            </a>
                        </li>
                        <li class="{{(Request::segment(2) == 'supplier') ? "active" : ""}}">
                            <a href="{{ route('seller.supplier.index') }}">
                                <i class="fa fa-list"></i> <span>Pemasok</span>
                            </a>
                        </li>
                        <li class="{{(Request::segment(2) == 'product') ? "active" : ""}}">
                            <a href="{{ route('seller.product.index') }}">
                                <i class="fa fa-list"></i> <span>Produk</span>
                            </a>
                        </li>
                        <li class="{{(Request::segment(2) == 'purchase') ? "active" : ""}}">
                            <a href="{{ route('seller.purchase.index') }}">
                                <i class="fa fa-list"></i> <span>Pembelian</span>
                            </a>
                        </li>
                        <li class="{{(Request::segment(2) == 'selling') ? "active" : ""}}">
                            <a href="{{ route('seller.selling.index') }}">
                                <i class="fa fa-list"></i> <span>Penjualan</span>
                            </a>
                        </li>
                        <li class="{{(Request::segment(2) == 'selling-online') ? "active" : ""}}">
                            <a href="{{ route('seller.selling-online.index') }}">
                                <i class="fa fa-list"></i> <span>Penjualan Online</span>
                            </a>
                        </li>
                        <li class="{{(Request::segment(2) == 'availability') ? "active" : ""}}">
                            <a href="{{ route('seller.availability.index') }}">
                                <i class="fa fa-list"></i> <span>Penyesuaian</span>
                            </a>
                        </li>
                        <li class="{{(Request::segment(2) == 'assembly') ? "active" : ""}}">
                            <a href="{{ route('seller.assembly.index') }}">
                                <i class="fa fa-list"></i> <span>Perakitan</span>
                            </a>
                        </li>
                        <li class="{{(Request::segment(2) == 'report-selling') ? "active" : ""}}">
                            <a href="{{ route('seller.report-selling.index') }}">
                                <i class="fa fa-list"></i> <span>Laporan Penjualan</span>
                            </a>
                        </li>
                        <li class="{{(Request::segment(2) == 'report-purchase') ? "active" : ""}}">
                            <a href="{{ route('seller.report-purchase.index') }}">
                                <i class="fa fa-list"></i> <span>Laporan Pembelian</span>
                            </a>
                        </li>
                        <li class="{{(Request::segment(2) == 'report-stock') ? "active" : ""}}">
                            <a href="{{ route('seller.report-stock.index') }}">
                                <i class="fa fa-list"></i> <span>Laporan Ketersediaan</span>
                            </a>
                        </li>
                        <li class="{{(Request::segment(2) == 'report-profit') ? "active" : ""}}">
                            <a href="{{ route('seller.report-profit.index') }}">
                                <i class="fa fa-list"></i> <span>Laporan Laba Rugi</span>
                            </a>
                        </li>
                    @endif
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @yield('header')

            <!-- Main content -->
            <section class="content container-fluid">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2020 <a href="#">{{ env('APP_NAME') }}</a>.</strong> All rights reserved.
        </footer>
        <!-- /.control-sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('/js/jquery.toast.min.js') }}"></script>
    @yield('js')
</body>

</html>
