<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.style')

    {{-- @yield('style') --}}

</head>

<body class="main-body app sidebar-mini ltr">

    <!-- Loader -->
    <div id="global-loader">
        <img class="loader-img" src="{{ asset('assets/img/gif/vg2.gif') }}" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- Page -->
    <div class="page custom-index">
        <div>
            <!-- main-header -->
            @include('layouts.header')
            <!-- main-header -->

            <!-- main-sidebar -->
            @include('layouts.sidebar')
            <!-- main-sidebar -->
        </div>

        <!-- main-content -->
        @yield('content')
        <!-- /main-content -->
        <footer>
            <div class="main-footer" id="footer">
                <div class="container-fluid pd-t-0 ht-100p">
                    <span> 2023 © Copyright Verdanco Group | Version 1.0</span>
                </div>
            </div>
        </footer>
        <!-- Footer closed -->

    </div>
    <!-- End Page -->

    <!-- Back-to-top -->
    <a id="back-to-top" href="#top">
        <i class="las la-angle-double-up"></i>
    </a>

    @include('layouts.script')
    {{-- @yield('script') --}}

</body>

</html>
