<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
<head>

    <meta charset="utf-8" />
    <title>Sign In | Hindkart - Block Franchise Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="SAI Admin Panel" name="description" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('public/dashboard_assets/images/favicon.png')}}">

    <!-- Layout config Js -->
    <script src="{{ URL::asset('public/dashboard_assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ URL::asset('public/dashboard_assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ URL::asset('public/dashboard_assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ URL::asset('public/dashboard_assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ URL::asset('public/dashboard_assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />

</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                {{-- <a href="{{ url('/') }}" class="d-inline-block auth-logo" style="background: #fff;padding: 10px;"> --}}
                                    {{-- <img src="{{ URL::asset('public/assets/images/logo-light.png')}}" alt="" style="height: 65px;"> --}}
                                {{-- </a> --}}
                            </div>
                            {{-- <p class="mt-3 fs-15 fw-medium" style="color: #fff;">Signin on Admin Panel</p> --}}
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    {{-- <h5 class="text-primary">Signin Account</h5> --}}
                                    <img src="{{ URL::asset('public/assets/images/logo.png')}}" alt="" style="height: 100px;">
                                    <p class="text-muted" style="font-size: 22px;color: navy !important;font-weight: 500;">Block Franchiser</p>
                                </div>
    @if(session()->has('success'))
        <div class="alert alert-secondary alert-dismissible alert-solid alert-label-icon fade show" role="alert">
            <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{ session()->get('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-warning alert-dismissible alert-solid alert-label-icon fade show" role="alert">
            <i class="ri-alert-line label-icon"></i><strong>Error</strong> - {{ session()->get('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>     
    @endif
                                <div class="p-2 mt-4">
                                    <form class="needs-validation" method="POST" action="{{ url('/block-franchise/login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter email address" required>
                                            <div class="invalid-feedback">
                                                Please enter email
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input type="password" class="form-control pe-5 password-input" onpaste="return false" name="password" value="{{ old('password') }}" placeholder="Enter password" required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>


                                        {{-- <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                            <h5 class="fs-13">Password must contain:</h5>
                                            <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b></p>
                                            <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter (a-z)</p>
                                            <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b> letter (A-Z)</p>
                                            <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)</p>
                                        </div> --}}

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Sign In</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                      

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                2023 Hindkart. Design & Developed by <i class="mdi mdi-heart text-danger"></i> by <a href="https://www.royinformatics.com/" target="_blank">Roy Informatics Pvt Ltd</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{ URL::asset('public/dashboard_assets/libs/bootstrap/js/bootstrap.bundle.min.js')}} "></script>
    <script src="{{ URL::asset('public/dashboard_assets/libs/simplebar/simplebar.min.js')}} "></script>
    <script src="{{ URL::asset('public/dashboard_assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{ URL::asset('public/dashboard_assets/libs/feather-icons/feather.min.js')}} "></script>
    <script src="{{ URL::asset('public/dashboard_assets/js/pages/plugins/lord-icon-2.1.0.js')}} "></script>
    <script src="{{ URL::asset('public/dashboard_assets/js/plugins.js')}}"></script>

    <!-- particles js -->
    <script src="{{ URL::asset('public/dashboard_assets/libs/particles.js/particles.js')}}"></script>
    <!-- particles app js -->
    <script src="{{ URL::asset('public/dashboard_assets/js/pages/particles.app.js')}}"></script>
    <!-- validation init -->
    <script src="{{ URL::asset('public/dashboard_assets/js/pages/form-validation.init.js')}} "></script>
    <!-- password create init -->
    <script src="{{ URL::asset('public/dashboard_assets/js/pages/passowrd-create.init.js')}}"></script>
</body>



</html>