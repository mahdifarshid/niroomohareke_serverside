<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    {{--<title>SB Admin - Dashboard</title>--}}
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/app.js')}}"></script>
    {{--<!-- Bootstrap core CSS-->--}}
    {{--<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">--}}

    {{--<!-- Custom fonts for this template-->--}}
    <link href="{{asset('css/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

    {{--<!-- Page level plugin CSS-->--}}
    <link href="{{asset('css/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet">

    {{--<!-- Custom styles for this template-->--}}
    <link href="{{asset('css/sb-admin.css')}}" rel="stylesheet">
    <style>
        html, body {
            margin: 0;
            height: 100%;
            /*overflow-x: hidden*/
        }
    </style>
    <style>
        .custombtn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: .200rem .75rem;
            font-size: .9rem;
            line-height: 1.6;
            border-radius: .25rem;
            -webkit-transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out
        }

    </style>


    @yield('header')
    <style>
  /*      @font-face {
            font-family: 'vazir';
            !*   src: url('webfont.eot'); !* IE9 Compat Modes *!
               src: url('webfont.eot?#iefix') format('embedded-opentype'), !* IE6-IE8 *!
               url('webfont.woff2') format('woff2'), !* Super Modern Browsers *!
               url('webfont.woff') format('woff'), !* Pretty Modern Browsers *!*!
            src: url('{{asset('vazir.ttf')}}') format('truetype'); !* Safari, Android, iOS *!
            !*url('webfont.svg#svgFontName') format('svg'); !* Legacy iOS *!*!
        }*/

        @font-face {
            font-family: 'vazir';

            src: url('{{asset('vazir.ttf')}}') format('truetype');

        }
        p, pre, input, a, button, h1, h2, h3, h4, h5, h6, ul, li, option, select {
            font-family: vazir, 'Segoe UI', Tahoma, sans-serif;
        }

        .nav-tree {
            display: none;
        }

        .nav-header {
            display: block;
        }

        @media only screen and (max-width: 770px) {
            .nav-tree {
                display: block;
                list-style: none;
                margin: 0;
                padding: 0;
            }

            .nav-header {
                display: none;
            }
        }
    </style>

    <style>
        .container {
            margin: 10px 30px;
            padding: 0;
        }

        @media only screen and (max-width: 500px) {
            .container {
                margin: 5px 10px;
                padding: 0;
            }
        }

        .header_text {
            margin: 0 auto;
            padding-right: 110px;
        }
    </style>
</head>

<body id="page-top" dir="rtl">

<nav class="navbar navbar-expand navbar-dark bg-dark static-top">


    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>
    <a class="navbar-brand mr-1" href="/">نیرو محرکه مهاباد</a>


    <p class="navbar-brand header_text">
        <script>
            var x = $("title")[0];
            document.write(x.innerHTML)
        </script>
    </p>
    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"
          style="padding-right: 25px;display: flex">
        <div class="input-group">
            {{--<input type="text" class="form-control" placeholder="جست وجو..." aria-label="Search" aria-describedby="basic-addon2">--}}
            {{--<div class="input-group-append">--}}
            {{--<button class="btn btn-primary" type="button">--}}
            {{--<i class="fas fa-search"></i>--}}
            {{--</button>--}}
            {{--</div>--}}
        </div>
    </form>
</nav>


<div id="wrapper">
    <!-- Sidebar -->

    <ul class="sidebar navbar-nav " style="margin: 0;padding: 0;">

        <li class="nav-item active dropdown  nav-header">
            <a class="nav-link " href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                {{--<i class="fas fa-fw fa-folder"></i>--}}
                <span>محصولات</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <a class="dropdown-item" href="{{url('/category')}}" style="text-align: right">دسته بندی محصولات</a>
                <a class="dropdown-item" href="{{url('/post')}}" style="text-align: right">پست ها</a>
                <a class="dropdown-item" href="{{url('/post/newpost')}}" style="text-align: right">پست جدید</a>
            </div>
        </li>


        <ul class="nav-tree">

            <li class="nav-item active">
                <a class="nav-link" href="{{url('/category')}}">
                    {{--<i class="fas fa-fw fa-list"></i>--}}
                    <span>دسته بندی محصولات</span></a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{url('/post/newpost')}}">
                    {{--<i class="fas fa-fw fa-book"></i>--}}
                    <span>پست جدید</span></a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{url('/post')}}">
                    {{--<i class="fas fa-fw fa-book"></i>--}}
                    <span>پست ها</span></a>
            </li>

        </ul>


        <li class="nav-item active dropdown nav-header">
            <a class="nav-link" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                {{--<i class="fas fa-fw fa-folder"></i>--}}
                <span>خدمات</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <a class="dropdown-item" href="{{url('/khadamat')}}" style="text-align: right">لیست خدمات</a>
                <a class="dropdown-item" href="{{url('/khadamat/new')}}" style="text-align: right">اضافه کردن خدمات</a>
            </div>
        </li>

        <ul class="nav-tree">

            <li class="nav-item active">
                <a class="nav-link" href="{{url('/khadamat')}}">
                    {{--<i class="fas fa-fw fa-book"></i>--}}
                    <span>لیست خدمات</span></a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{url('/khadamat/new')}}">
                    {{--<i class="fas fa-fw fa-book"></i>--}}
                    <span>اضافه کردن خدمات</span></a>
            </li>
        </ul>


        <li class="nav-item active">
            <a class="nav-link" href="{{url('/gallery')}}">
                {{--<i class="fas fa-fw fa-book"></i>--}}
                <span>گالری عکس</span></a>
        </li>


        {{--<li class="nav-item active">--}}
        {{--<a class="nav-link" href="{{url('/document')}}">--}}
        {{--<i class="fas fa-fw fa-book"></i>--}}
        {{--<span>مستندات</span></a>--}}
        {{--</li>--}}


        <li class="nav-item active dropdown nav-header">
            <a class="nav-link" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                {{--<i class="fas fa-fw fa-folder"></i>--}}
                <span>مستندات</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <a class="dropdown-item" href="{{url('/document/category')}}" style="text-align: right">دسته بندی</a>
                <a class="dropdown-item" href="{{url('/document')}}" style="text-align: right">مستندات</a>
            </div>
        </li>

        <ul class="nav-tree">

            <li class="nav-item active">
                <a class="nav-link" href="{{url('/document/category')}}">
                    {{--<i class="fas fa-fw fa-book"></i>--}}
                    <span>دسته بندی مستند ها</span></a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{url('/document')}}">
                    {{--<i class="fas fa-fw fa-book"></i>--}}
                    <span>مستندات</span></a>
            </li>
        </ul>

        <li class="nav-item active">
            <a class="nav-link" href="{{url('/setting')}}">
                {{--<i class="fas fa-fw fa-book"></i>--}}
                <span>تنظیمات</span></a>
        </li>


        <li class="nav-item active">
            <a class="nav-link" href="{{url('/logout') }}">
                {{--<i class="fas fa-fw fa-book"></i>--}}
                <span>خروج از حساب کاربری</span></a>
        </li>

    </ul>

    @yield('content')

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
{{--<script src="vendor/jquery/jquery.min.js"></script>--}}
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Page level plugin JavaScript-->
<script src="{{asset('js/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('js/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('js/datatables/dataTables.bootstrap4.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('js/sb-admin.min.js')}}"></script>

<!-- Demo scripts for this page-->
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
<script src="{{asset('js/demo/chart-area-demo.js')}}"></script>

</body>

</html>
