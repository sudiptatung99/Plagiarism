<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('image/favicon.ico') }}" type="image/x-icon">
    <title>{{ config('app.name', 'eAarjav') }} - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css?v1.1.1') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style_custom.css') }}" />

</head>

<style>
    p {
        margin: 0;
    }
</style>

<body class="nk-body" data-sidebar-collapse="lg" data-navbar-collapse="lg">
    <div class="nk-app-root">
        <div class="nk-main">
            <div class="nk-sidebar nk-sidebar-fixed is-theme" id="sidebar">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-sidebar-brand">
                        <a href="{{ route('dashboard') }}" class="logo-link">
                            <div class="logo-wrap">
                                <img class="logo-img logo-light"
                                    src="{{asset('image/logo.svg')}}"
                                    srcset="./images/logo2x.png 2x" alt="" />
                                <img class="logo-img logo-dark"
                                    src="{{asset('image/logo.svg')}}"
                                    srcset="./images/logo-dark2x.png 2x" alt="" />
                                <img class="logo-img logo-icon"
                                    src="{{asset('image/logo.svg')}}"
                                    srcset="./images/logo-icon2x.png 2x" alt="" />
                            </div>
                        </a>
                        <div class="nk-compact-toggle me-n1">
                            <button class="btn btn-md btn-icon text-light btn-no-hover compact-toggle">
                                <em class="icon off ni ni-chevrons-left"></em>
                                <em class="icon on ni ni-chevrons-right"></em>
                            </button>
                        </div>
                        <div class="nk-sidebar-toggle me-n1">
                            <button class="btn btn-md btn-icon text-light btn-no-hover sidebar-toggle">
                                <em class="icon ni ni-arrow-left"></em>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="nk-sidebar-element nk-sidebar-body total_sidebar">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                                <li class="nk-menu-item has-sub">
                                    <a href="{{ url('dashboard') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                                        <span class="nk-menu-text">Home</span>
                                    </a>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-chevron-right-c"></em></span>
                                        <span class="nk-menu-text">Plan</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('plan.index') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">View</span>
                                            </a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('plan.create') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">Add</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-chevron-right-c"></em></span>
                                        <span class="nk-menu-text">User</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('user.all') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">View</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-chevron-right-c"></em></span>
                                        <span class="nk-menu-text">User Plan</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('plans.user') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">View</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-chevron-right-c"></em></span>
                                        <span class="nk-menu-text">FAQ</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('faq.index') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">View</span>
                                            </a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('faq.create') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">Create</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-chevron-right-c"></em></span>
                                        <span class="nk-menu-text">Activity</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('active-log') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">View</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-wrap client_datafull">
                <div class="nk-header nk-header-fixed">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-header-logo ms-n1">
                                <div class="nk-navbar-toggle me-2">
                                    <button class="btn btn-sm btn-icon btn-zoom navbar-toggle d-sm-none">
                                        <em class="icon ni ni-menu-right"></em>
                                    </button>
                                    <button class="btn btn-md btn-icon btn-zoom navbar-toggle d-none d-sm-inline-flex">
                                        <em class="icon ni ni-menu-right"></em>
                                    </button>
                                </div>
                                <a href="./html/index.html" class="logo-link">
                                    <div class="logo-wrap">
                                        <img class="logo-img logo-light" src="./images/logo.png"
                                            srcset="./images/logo2x.png 2x" alt />
                                        <img class="logo-img logo-dark" src="./images/logo-dark.png"
                                            srcset="./images/logo-dark2x.png 2x" alt />
                                        <img class="logo-img logo-icon" src="./images/logo-icon.png"
                                            srcset="./images/logo-icon2x.png 2x" alt />
                                    </div>
                                </a>
                            </div>
                            <nav class="nk-header-menu nk-navbar top_btn">
                                <ul class="nk-nav">
                                </ul>
                            </nav>
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav ms-2">
                                    <li class="dropdown">
                                        <a href="#" data-bs-toggle="dropdown">
                                            <div class="d-sm-none">
                                                <div class="media media-md media-circle">
                                                    <img src="https://w7.pngwing.com/pngs/981/645/png-transparent-default-profile-united-states-computer-icons-desktop-free-high-quality-person-icon-miscellaneous-silhouette-symbol-thumbnail.png"
                                                        alt class="img-thumbnail" />
                                                </div>
                                            </div>
                                            <div class="d-none d-sm-block">
                                                <div class="media media-circle">
                                                    <img src="https://w7.pngwing.com/pngs/981/645/png-transparent-default-profile-united-states-computer-icons-desktop-free-high-quality-person-icon-miscellaneous-silhouette-symbol-thumbnail.png"
                                                        alt class="img-thumbnail" />
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md">
                                            <div
                                                class="dropdown-content dropdown-content-x-lg py-3 border-bottom border-light">
                                                <div class="media-group">
                                                    <div class="media media-xl media-middle media-circle">
                                                        <img src="https://w7.pngwing.com/pngs/981/645/png-transparent-default-profile-united-states-computer-icons-desktop-free-high-quality-person-icon-miscellaneous-silhouette-symbol-thumbnail.png"
                                                            alt class="img-thumbnail" />
                                                    </div>
                                                    <div class="media-text">
                                                        <div class="lead-text">
                                                            {{ Auth::guard('admin')->user()->name }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="dropdown-content dropdown-content-x-lg py-3 border-bottom border-light">
                                                <ul class="link-list">
                                                    <li>
                                                        <a href="{{ route('profile.edit') }}"><em
                                                                class="icon ni ni-user"></em>
                                                            <span>Profile</span></a>
                                                    </li>

                                                    <li>
                                                        <a href="{{ route('password.edit') }}"><em
                                                                class="icon ni ni-setting-alt"></em>
                                                            <span>Password</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-content dropdown-content-x-lg py-3">
                                                <ul class="link-list">
                                                    <li>
                                                        <form method="POST" action="{{ route('logout') }}">
                                                            @csrf
                                                            <a href="route('logout')"
                                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();"><em
                                                                    class="icon ni ni-signout"></em>
                                                                <span>Log Out</span></a>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- .nk-header-tools -->
                        </div>
                        <!-- .nk-header-wrap -->
                    </div>
                    <!-- .container-fliud -->
                </div>
                <!-- header -->
                <!-- content -->
                <div class="nk-content">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <main>
                                    {{ $slot }}
                                </main>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .nk-content -->
                <!-- include Footer -->
                <!-- .nk-footer -->
            </div>
            <!-- .nk-wrap -->
        </div>
        <!-- .nk-main -->
    </div>

</body>

<script src="{{ asset('admin/assets/js/bundle.js') }}"></script>
<script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
<script src="{{ asset('admin/assets/js/charts/analytics-chart.js') }}"></script>
<script src="{{ asset('admin/assets/js/data-tables/data-tables.js') }}"></script>
<script src="https://cdn.tiny.cloud/1/s8cy46rga9zuv1nvnn6ilvp5zjtcci9ym3ckb1mebj7jh5qj/tinymce/6/tinymce.min.js"
    referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
</script>
@stack('js');
<script>
    function showDiv() {
        document.getElementById('more-data').style.display = "block";
    }
</script>
@stack('js')

</html>
