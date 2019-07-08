<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ __('Tpl@ Cooking') }} - @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/dist/css/AdminLTE.min.css') }}">

    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/dist/css/skins/skin-blue.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/custom.css') }}">
    <!-- Google Font -->
    <link rel="stylesheet" href="{{ asset('css/admin/font.css') }}">

    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">
    @yield('custom_css')
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        @section('sidebar')
        <header class="main-header">
            <!-- Logo -->
            <a href="index2.html" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>T</b>PL</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>{{ __('Tpl@') }}</b>{{ __(' Cooking') }}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ __('Toggle navigation') }}</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('home') }}">{{ __('Go To User Page') }}</a></li>
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    @if (Auth::user()->avatar != null)
                                    <img src="{{ asset('upload/' . Auth::user()->avatar) }}" class="img-circle">
                                    @else
                                    <img src="{{ asset('images/default2.png') }}" class="img-circle">
                                    @endif
                                    <p>
                                        {{ __('Admin- Tpl@') }}
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                            class="btn btn-default btn-flat">{{ __('Sign out') }}</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <!-- /.messages-menu -->
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="" class="img-circle">
                    </div>
                    <div class="pull-left info">
                        <p>{{  Auth::user()->name }}</p>
                        <!-- Status -->
                    </div>
                </div>

                <!-- search form (Optional) -->
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                                    class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <!-- /.search form -->

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">{{ __('HEADER') }}</li>
                    <!-- Optionally, you can add icons to the links -->
                    <li class="treeview">
                        <a href="#"><i class="fa fa-link"></i> <span>{{ __('Manage Recipes') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('recipes.index') }}">{{ __('Recipes list') }}</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-link"></i> <span>{{ __('Manage Categories') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('categories.index') }}">{{ __('Category list') }}</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-link"></i> <span>{{ __('Manage Comments') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.comment.index') }}">{{ __('Recipes Comments') }}</a></li>
                            <li><a href="{{ route('admin.comment.post') }}">{{ __('Posts Comments') }}</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-link"></i> <span>{{ __('Manage Gift List') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('gifts.index') }}">{{ __('Gift List') }}</a></li>
                            <li><a href="{{ route('gift-take.list') }}">{{ __('Receive List') }}</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('manage-post.index') }}"><i class="fa fa-link"></i>
                            <span>{{ __('Manage Posts') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}"><i class="fa fa-link"></i>
                            <span>{{ __('Manage Users') }}</span>
                        </a>
                    </li>

                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @show

        @yield('content')

        @section('footer')
        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- Default to the left -->
            <strong>{{ __('Copyright ') }}&copy; {{ __('2016') }} <a href="#">{{ __('Sun') }}</a>.</strong>
            {{ __('All rights reserved.') }}
            <input type="hidden" class="toastr-session"
                data-session="{{ Session::has('message') . ',' . Session::get('alert-type', 'info') . ',' . Session::get('message') }}">
        </footer>
        @show
    </div>
    @section('script')
    <!-- jQuery 3 -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('bower_components/admin-lte/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/admin/master.js') }}"></script>
    <script src="{{ asset('bower_components/toastr/toastr.js') }}"></script>
    @show
</body>

</html>
