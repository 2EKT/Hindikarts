@include("zonal-franchise.include.header");
@include("zonal-franchise.include.sidebar");
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Wallet</h4>
                        
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                   
                                    <div class="col-xxl-3 col-md-6">
                                        <img src="{{ asset('dashboard_assets/images/wallet.png')}}" style="height:80px;">
                                        <p>Current Balance : Rs {{Auth::guard('zonepartner')->user()->wallet_balance}}/-</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->

</div>
<!-- container-fluid -->
</div>
<!-- End Page-content -->
@include("zonal-franchise.include.footer");