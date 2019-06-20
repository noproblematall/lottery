<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CMS') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{asset('js/jquery.min.js')}}" defer></script> --}}
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">

    <!-- jQuery library -->
    <script src="{{asset('js/jquery.min.js')}}"></script>

    <!-- Popper JS -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> --}}

    <!-- Latest compiled JavaScript -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="{{ asset('js/sweetalert.min.js') }}" defer></script>
    {{-- <script src="{{ asset('js/data.js') }}" defer></script> --}}
    <script src="{{ asset('js/main.js') }}" defer></script>
    

    <script type="text/javascript" language="javascript" src="{{asset('DataTables/js/jquery.dataTables.min.js')}}" defer></script>
    <script type="text/javascript" language="javascript" src="{{asset('DataTables/js/dataTables.bootstrap4.min.js')}}" defer></script>
    <script type="text/javascript" language="javascript" src="{{asset('DataTables/js/dataTables.buttons.min.js')}}" defer></script>
    <script type="text/javascript" language="javascript" src="{{asset('DataTables/js/buttons.bootstrap4.min.js')}}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        <div class="app-header header-shadow bg-dark header-text-light">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>    
            <div class="app-header__content">                
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <img width="42" class="rounded-circle" src="{{asset(Auth::user()->photo)}}" alt="Avatar">
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-menu-header">
                                                <div class="dropdown-menu-header-inner bg-info">
                                                    <div class="menu-header-image opacity-2" style="background-image: url('{{asset('images/dropdown-header/city1.jpg')}}');"></div>
                                                    <div class="menu-header-content text-left">
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left mr-3">
                                                                    <img width="42" class="rounded-circle"
                                                                         src="{{asset(Auth::user()->photo)}}" alt="Avatar">
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading">{{Auth::user()->username}}</div>
                                                                    <div class="widget-subheading opacity-8">Welcome to CMS</div>
                                                                </div>
                                                                <div class="widget-content-right mr-2">
                                                                    <a class="btn-pill btn-shadow btn-shine btn btn-focus" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                                        {{ __('Logout') }}
                                                                    </a>
                                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                                        @csrf
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <h5>Welcome to CMS</h5>
                                            </div>
                                            <ul class="nav flex-column">
                                                <li class="nav-item-divider mb-0 nav-item"></li>
                                                <div class="mt-2 text-center">
                                                    <a class="btn-pill btn-shadow btn-shine btn btn-focus" href="{{route('setting')}}">
                                                        {{ __('User Setting') }}
                                                    </a>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        {{Auth::user()->username}}
                                    </div>
                                    <div class="widget-subheading">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="app-main">
            <div class="app-sidebar sidebar-shadow bg-dark sidebar-text-light">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>    
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <br />
                            <li>
                                <a href="{{route('admin.index')}}">
                                    <i class="metismenu-icon pe-7s-home"></i>
                                    HOME
                                </a>                                    
                            </li>
                            <li>
                                <a href="{{route('admin.user')}}">
                                    <i class="metismenu-icon pe-7s-users"></i>
                                    USER MANAGEMENT
                                </a>                                    
                            </li>
                            <li>
                                <a href="{{route('admin.win_number')}}">
                                    <i class="metismenu-icon pe-7s-medal"></i>
                                    WINNING NUMBERS
                                </a>                                    
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            @yield('subtitle')
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                            {{-- <div class="row"> --}}
                                @yield('content')
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>                    
            </div>
        </div>
    </div>    
    {{-- <div class="app-drawer-overlay d-none animated fadeIn"></div> --}}
    @yield('modal')
    @yield('script')
    
</body>
</html>
