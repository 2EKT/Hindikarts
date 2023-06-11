<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="app-menu navbar-menu" style="background-color:rgb(4,112,170) !important;  opacity: 0.9 !important;">
    <!-- LOGO -->
    <div class="navbar-brand-box" style="background: #fff;">
      
        <!-- Light Logo-->
        <a href="{{ url('/') }}" class="logo logo-light">
            {{-- <span class="logo-sm" style="background: #fff;padding: 18px 12px;">
                <img src="{{ asset('assets/images/logo.png')}}" alt="" height="45">
            </span> --}}
            <span class="logo-lg" >
                <img src="{{ asset('assets/images/logo.png')}}" alt="" height="45">
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
                <li class="menu-title"><span data-key="t-menu">Zone Franchiser Panel</span></li>
                <li class="nav-item">
                    <a class="nav-link {{$page_name=='dashboard'?'active':''}}" href="{{ url('/zonal-franchise/dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li> 

                <li class="nav-item">
                    <a class="nav-link {{$page_name=='district-partner'?'active':''}}" href="{{ url('/zonal-franchise/districtpartner/create') }}">
                        <i class="fa fa-user-o" aria-hidden="true"></i> <span data-key="t-dashboards">Add District Partner</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{$page_name=='district-partner'?'active':''}}" href="{{ url('/zonal-franchise/district-partner') }}">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i> <span data-key="t-dashboards">District Partner List</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{$page_name=='block-partner'?'active':''}}" href="{{ url('/zonal-franchise/block-partner') }}">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i> <span data-key="t-dashboards">Block Partner List</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{$page_name=='employee'?'active':''}}" href="{{ url('/zonal-franchise/employee') }}">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i> <span data-key="t-dashboards">Employee List</span>
                    </a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link {{$page_name=='merchant'?'active':''}}" href="{{ url('/zonal-franchise/merchant') }}">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i> <span data-key="t-dashboards">Merchant List</span>
                    </a>
                </li> 
            
                <li class="nav-item">
                    <a class="nav-link {{$page_name=='business-details'?'active':''}}" href="{{ url('/zonal-franchise/business-details') }}">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i> <span data-key="t-dashboards">Business Details</span>
                    </a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link {{$page_name=='wallet'?'active':''}}" href="{{ url('/zonal-franchise/wallet') }}">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i> <span data-key="t-dashboards">Wallet</span>
                    </a>
                </li>  
                <li class="nav-item">
                    <a class="nav-link {{$page_name=='payments'?'active':''}}" href="{{ url('/zonal-franchise/payments') }}">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i> <span data-key="t-dashboards">Payment</span>
                    </a>
                </li> 

                <li class="nav-item">
                    <a class="nav-link {{$page_name=='admin_logout'?'active':''}}" href="{{ url('/zonal-franchise/logout') }}">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> <span data-key="t-dashboards">Logout</span>
                    </a>
                </li> 

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>