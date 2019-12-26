<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>M-Agri</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('assets/images/logo.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('assets/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('assets/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="{{ asset('assets/plugins/morrisjs/morris.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- Sweet Alert Css -->
    <link href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />

    <!-- Select2 Css -->
    <link href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('assets/css/themes/all-themes.css') }}" rel="stylesheet" />

    <!-- Styles -->
    @if (App::isLocal())
        <!-- Sweet Alert Css -->
        <link href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />

        <!-- Select2 Css -->
        <link href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />

        <!-- Jquery-ui Css -->
        <link href="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" />

        <!-- Bootstrap Core Css -->
        <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

        <!-- Waves Effect Css -->
        <link href="{{ asset('assets/plugins/node-waves/waves.css') }}" rel="stylesheet" />

        <!-- Animation Css -->
        <link href="{{ asset('assets/plugins/animate-css/animate.css') }}" rel="stylesheet" />

        <!-- Morris Chart Css-->
        <link href="{{ asset('assets/plugins/morrisjs/morris.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/themes/all-themes.css') }}" rel="stylesheet" />

        <!-- JQuery DataTable Css -->
        <link href="{{ asset('assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">

        <!-- DataTable Fixed Columns Css -->
        <link href="{{ asset('assets/css/fixedColumn.min.css') }}" rel="stylesheet">
        
        <!-- Custom Css -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    @else
        @if (Request::server('HTTP_X_FORWARDED_PROTO') == 'http')
        <!-- Sweet Alert Css -->
        <link href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />

        <!-- Select2 Css -->
        <link href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />

        <!-- Jquery-ui Css -->
        <link href="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" />

        <!-- Bootstrap Core Css -->
        <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

        <!-- Waves Effect Css -->
        <link href="{{ asset('assets/plugins/node-waves/waves.css') }}" rel="stylesheet" />

        <!-- Animation Css -->
        <link href="{{ asset('assets/plugins/animate-css/animate.css') }}" rel="stylesheet" />

        <!-- Morris Chart Css-->
        <link href="{{ asset('assets/plugins/morrisjs/morris.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/themes/all-themes.css') }}" rel="stylesheet" />

        <!-- JQuery DataTable Css -->
        <link href="{{ asset('assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">

        <!-- DataTable Fixed Columns Css -->
        <link href="{{ asset('assets/css/fixedColumn.min.css') }}" rel="stylesheet">

        <!-- Custom Css -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        @else
        <!-- Sweet Alert Css -->
        <link href="{{ secure_asset('assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />

        <!-- Select2 Css -->
        <link href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />

        <!-- Jquery-ui Css -->
        <link href="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" />

        <!-- Bootstrap Core Css -->
        <link href="{{ secure_asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

        <!-- Waves Effect Css -->
        <link href="{{ secure_asset('assets/plugins/node-waves/waves.css') }}" rel="stylesheet" />

        <!-- Animation Css -->
        <link href="{{ secure_asset('assets/plugins/animate-css/animate.css') }}" rel="stylesheet" />

        <!-- Morris Chart Css-->
        <link href="{{ secure_asset('assets/plugins/morrisjs/morris.css') }}" rel="stylesheet" />
        <link href="{{ secure_asset('assets/css/themes/all-themes.css') }}" rel="stylesheet" />

        <!-- JQuery DataTable Css -->
        <link href="{{ secure_asset('assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">

        <!-- DataTable Fixed Columns Css -->
        <link href="{{ asset('assets/css/fixedColumn.min.css') }}" rel="stylesheet">
        
        <!-- Custom Css -->
        <link href="{{ secure_asset('assets/css/style.css') }}" rel="stylesheet">
        @endif
    @endif
    @if(Request::path() == 'purchases' || Request::path() == 'outbound' || Request::path() == 'sales' || Request::path() == 'expense' || Request::path() == 'trips'|| Request::path() == 'summary')
    <style>
        #ui-datepicker-div .ui-datepicker-calendar {
            display: table !important;
        }
    </style>
    @endif
</head>
<body  id="b"  class="theme-grey">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-grey">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Initializing...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
   
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0)" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0)" class="bars" id="l" ></a>
                <a class="navbar-brand" href="{{ route('home') }}"><span> <img src="{{ asset('assets/images/logo.png') }}" width="50" height="50" class="logo"/></span> <span class="title">M-Agri</span></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                  
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown" id="request">
                        <notification-counter :count="count"></notification-counter>
                        <notification-list :requests="requests"></notification-list>
                    </li>
                    <!-- #END# Notifications -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="{{ asset('assets/images/user1.png') }}" width="50" height="50" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{!! getName()->fname !!}</div>
                    <div class="email">{{ Auth::user()->username }} &nbsp;  ₱<span id="curCashOnHand">{{ number_format(Auth::user()->cashOnHand,2) }}</span></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('profile') }}"><i class="material-icons">person</i>Profile</a></li>
                            @if($permissions = userpermission())
                            @foreach($permissions as $key => $permission)
                                @if(strpos($permissions[$key]->permission->middleware, 'manage') !== false && $permission->permit == 1)
                                    {{$routeName = '/'.str_replace('manage_', '', $permissions[$key]->permission->middleware)}};
                                    <li role="seperator" class="divider"></li>
                                    <li><a href="{{ route('home') }}"><i class="material-icons">group</i>Main Navigation</a></li>
                                    <li><a href="{{ $routeName }}"><i class="material-icons">group</i>Manage</a></li>
                                    <li role="seperator" class="divider"></li>
                                    @break
                                @endif
                            @endforeach
                            @endif
                            <li>
							    <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Sign Out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            @auth
            <div class="menu">
                <ul class="list">
                    @if(Request::path() == 'company' || Request::path() == 'employee' || Request::path() == 'customer' || Request::path() == 'trucks' || Request::path() == 'commodity')
                        <li class="header">Manage Settings</li>
                        @if($permissions = userpermission())
                            @foreach($permissions as $key => $permission)
                                @if($permissions[$key]->permission->middleware == "manage_company" && $permission->permit == 1 || Auth::user()->access_id == 1)
                                <li class="{{ (Request::path() == 'company') ? 'active' : '' }}">
                                    <a href="{{ route('company') }}">
                                        <i class="material-icons">business</i>
                                        <span>Company</span>
                                    </a>
                                </li>
                                @endif
                                @if($permissions[$key]->permission->middleware == "manage_employee" && $permission->permit == 1 || Auth::user()->access_id == 1)
                                <li class="{{ (Request::path() == 'employee') ? 'active' : '' }}">
                                    <a href="{{ route('employee') }}">
                                        <i class="material-icons">supervisor_account</i>
                                        <span>Employee</span>
                                    </a>
                                </li>
                                @endif
                                @if($permissions[$key]->permission->middleware == "manage_customer" && $permission->permit == 1 || Auth::user()->access_id == 1)
                                <li class="{{ (Request::path() == 'customer') ? 'active' : '' }}">
                                    <a href="{{ route('customer') }}">
                                        <i class="material-icons">tag_faces</i>
                                        <span>Customer</span>
                                    </a>
                                </li>
                                @endif
                                @if($permissions[$key]->permission->middleware == "manage_trucks" && $permission->permit == 1 || Auth::user()->access_id == 1)
                                <li class="{{ (Request::path() == 'trucks') ? 'active' : '' }}">
                                    <a href="{{ route('trucks') }}">
                                        <i class="material-icons">local_shipping</i>
                                        <span>Trucks</span>
                                    </a>
                                </li>
                                @endif
                                @if($permissions[$key]->permission->middleware == "manage_commodity" && $permission->permit == 1 || Auth::user()->access_id == 1)
                                <li class="{{ (Request::path() == 'commodity') ? 'active' : '' }}">
                                    <a href="{{ route('commodity') }}">
                                        <i class="material-icons">receipt</i>
                                        <span>Commodity</span>
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        @endif
                    @else
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="{{ (Request::path() == 'home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                            </a>
                        </li>
                        @if($permissions = userpermission())
                            @foreach($permissions as $key => $permission)
                                @if($permissions[$key]->permission->middleware == "summary" && $permission->permit == 1 || Auth::user()->access_id == 1)
                                <li class="{{ (Request::path() == 'summary') ? 'active' : '' }}">
                                    <a href="{{ route('summary') }}">
                                        <i class="material-icons">assessment</i>
                                        <span>Summary</span>
                                    </a>
                                </li>
                                @endif
                                @if($permissions[$key]->permission->middleware == "expenses" && $permission->permit == 1 || Auth::user()->access_id == 1)
                                <li class="{{ (Request::path() == 'expense') ? 'active' : '' }}">
                                    <a href="{{ route('expense') }}">
                                        <i class="material-icons">show_chart</i>
                                        <span>Expenses</span>
                                    </a>
                                </li>
                                @endif
                                @if($permissions[$key]->permission->middleware == "trips" && $permission->permit == 1 || Auth::user()->access_id == 1)
                                <li class="{{ (Request::path() == 'trips') ? 'active' : '' }}">
                                    <a href="{{ route('trips') }}">
                                        <i class="material-icons">directions_bus</i>
                                        <span>Trips</span>
                                    </a>
                                </li>
                                @endif
                                @if($permissions[$key]->permission->middleware == "dtr" && $permission->permit == 1 || Auth::user()->access_id == 1)
                                <li class="{{ (Request::path() == 'dtr') ? 'active' : '' }}">
                                    <a href="{{ route('dtr') }}">
                                        <i class="material-icons">access_time</i>
                                        <span>Daily Time Record</span>
                                    </a>
                                </li>
                                @endif
                                @if($permissions[$key]->permission->middleware == "od" && $permission->permit == 1 || Auth::user()->access_id == 1)
                                <li class="{{ (Request::path() == 'outbound') ? 'active' : '' }}">
                                    <a href="{{ route('od') }}">
                                        <i class="material-icons">arrow_upward</i>
                                        <span>Outbound Deliveries</span>
                                    </a>
                                </li>
                                @endif
                                @if($permissions[$key]->permission->middleware == "ca" && $permission->permit == 1 || Auth::user()->access_id == 1)
                                <li class="{{ (Request::path() == 'cashadvance') ? 'active' : '' }}">
                                    <a href="{{ route('ca') }}">
                                        <i class="material-icons">monetization_on</i>
                                        <span>Cash Advance</span>
                                    </a>
                                </li>
                                @endif
                                @if($permissions[$key]->permission->middleware == "purchases" && $permission->permit == 1 || Auth::user()->access_id == 1)
                                <li class="{{ (Request::path() == 'purchases') ? 'active' : '' }}">
                                    <a href="{{ route('purchases') }}">
                                        <i class="material-icons">bookmark_border</i>
                                        <span>Purchases</span>
                                    </a>
                                </li>
                                @endif
                                @if($permissions[$key]->permission->middleware == "sales" && $permission->permit == 1 || Auth::user()->access_id == 1)
                                <li class="{{ (Request::path() == 'sales') ? 'active' : '' }}">
                                    <a href="{{ route('sales') }}">
                                        <i class="material-icons">shopping_cart</i>
                                        <span>Sales</span>
                                    </a>
                                </li>
                                @endif
                               
                            @endforeach
                        @endif
                    @endif
                </ul>
            </div>
            @endauth
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2020 <a href="javascript:void(0);">Solid Script Web Systems</a>.
                </div>

            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->

    </section>
    <section class="content">
        @yield('content')
    </section >

    <!-- Scripts -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    @yield('script')

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('assets/plugins/node-waves/waves.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('assets/js/admin.js') }}"></script>

    <!-- Sweet Alert Plugin Js -->
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Select2 Plugin Js -->
    <script src="{{ asset('assets/plugins/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Select Plugin Js -->
    <script src="{{ asset('assets/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('assets/plugins/jquery-countto/jquery.countTo.js') }}"></script>

    <!-- Morris Plugin Js -->
    <script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/morrisjs/morris.js') }}"></script>

    <!-- ChartJs -->
    <script src="{{ asset('assets/plugins/chartjs/Chart.bundle.js') }}"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="{{ asset('assets/plugins/flot-charts/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot-charts/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot-charts/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot-charts/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot-charts/jquery.flot.time.js') }}"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="{{ asset('assets/plugins/jquery-sparkline/jquery.sparkline.js') }}"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('assets/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/fixedColumn.min.js') }}"></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.js') }}"></script>

    <!-- Jquery-ui Css -->
    <link href="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" />

    <!-- Custom Js -->
    <script src="{{ asset('assets/js/admin.js') }}"></script>
    <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
    <script src="{{ asset('assets/js/pages/ui/modals.js') }}"></script>
    <script src="{{ asset('assets/js/pages/forms/form-validation.js') }}"></script>

    <!-- Demo Js -->
    <script src="{{ asset('assets/js/demo.js') }}"></script>

    <!-- Jquery-ui Js -->
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
    $('#l').click(function(){
        //alert('hey')
        if($('#b').hasClass('overlay-open') )
        {

            $('#b').removeClass('overlay-open');
        }
        else{
        // $('#b').removeClass('ls-closed');
        $('#b').addClass('overlay-open');
        }
    });
    </script>

    <!-- App Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
