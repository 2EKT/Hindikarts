@yield('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
      
        <!-- Light Logo-->
        <a href="{{ url('/') }}" class="logo logo-light">
            <span class="logo-sm" style="background: #fff;padding: 18px 12px;">
                <img src="{{ URL::asset('public/assets/images/logo.png')}}" alt="" height="45">
            </span>
            <span class="logo-lg" style="background: #fff;padding: 18px 12px;">
                <img src="{{ URL::asset('public/assets/images/logo.png')}}" alt="" height="45">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
@php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$path=explode('/', $actual_link);
$page_name=$path[4];
@endphp
    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Employee Panel</span></li>
                <li class="nav-item">
                    <a class="nav-link {{$page_name=='dashboard'?'active':''}}" href="{{ url('/employee/dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li> 

                <li class="nav-item">
                    <a class="nav-link {{$page_name=='merchant'?'active':''}}" href="{{ url('/employee/merchant/create') }}">
                        <i class="fa fa-user-o" aria-hidden="true"></i> <span data-key="t-dashboards">Add Merchant</span>
                    </a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link {{$page_name=='merchant'?'active':''}}" href="{{ url('/employee/merchant') }}">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i> <span data-key="t-dashboards">Merchant List</span>
                    </a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link {{$page_name=='business-details'?'active':''}}" href="{{ url('/employee/business-details') }}">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i> <span data-key="t-dashboards">Business Details</span>
                    </a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link {{$page_name=='wallet'?'active':''}}" href="{{ url('/employee/wallet') }}">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i> <span data-key="t-dashboards">Wallet</span>
                    </a>
                </li> 

                <li class="nav-item">
                    <a class="nav-link {{$page_name=='merchant-shops'?'active':''}}" href="{{ url('/employee/merchant-shops/create') }}">
                        <i class="fa fa-user-o" aria-hidden="true"></i> <span data-key="t-dashboards">Add Merchant Shop</span>
                    </a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link {{$page_name=='merchant-shops'?'active':''}}" href="{{ url('/employee/merchant-shops') }}">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i> <span data-key="t-dashboards">Merchant Shop</span>
                    </a>
                </li> 
               

                <li class="nav-item">
                    <a class="nav-link {{$page_name=='logout'?'active':''}}" href="{{ url('/employee/logout') }}">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> <span data-key="t-dashboards">Logout</span>
                    </a>
                </li> 

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>