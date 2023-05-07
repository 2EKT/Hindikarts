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
                <li class="menu-title"><span data-key="t-menu">Merchant Panel</span></li>
                <li class="nav-item">
                    <a class="nav-link {{$page_name=='dashboard'?'active':''}}" href="{{ url('/merchant/dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li> 

                <li class="nav-item">
                    <a class="nav-link " href="{{ url('/merchant/product/create') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Add Product</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/merchant/product') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Product List</span>
                    </a>
                </li> 
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/merchant/wallet') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Wallet</span>
                    </a>
                </li> 

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps1" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span data-key="t-apps">Orders</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps1">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('/merchant/new-orders') }}" class="nav-link {{$page_name=='new-orders'?'active':''}}" data-key="t-calendar"> New Orders </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/merchant/accepted-orders') }}" class="nav-link {{$page_name=='accepted-orders'?'active':''}}" data-key="t-calendar"> Accepted Orders </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/merchant/completed-orders') }}" class="nav-link {{$page_name=='completed-orders'?'active':''}}" data-key="t-calendar"> Completed Orders </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/merchant/cancelled-orders') }}" class="nav-link {{$page_name=='cancelled-orders'?'active':''}}" data-key="t-calendar"> Cancelled Orders </a>
                            </li>
                      </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/merchant/payments') }}">
                        <i class="fa fa-money"></i> <span data-key="t-dashboards">Payment</span>
                    </a>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link {{$page_name=='logout'?'active':''}}" href="{{ url('/merchant/logout') }}">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> <span data-key="t-dashboards">Logout</span>
                    </a>
                </li> 

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>