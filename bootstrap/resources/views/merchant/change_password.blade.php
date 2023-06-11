@include("merchant.include.header");
@include("merchant.include.sidebar");
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Change Password</h4>
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

    @if ($errors->any())
    <div class="alert alert-danger p-1 mt-2">
        <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
        </ul>
    </div>
    @endif
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form action="{{ url('/merchant/update_password') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                <div class="row gy-4">
                                   
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Create New Passowrd</label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Create New Passowrd" required>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="formFile" class="form-label">Confirm Password</label>
                                            <input class="form-control" type="password" id="confirm_password" placeholder="Confirm Password" required>
                                            <span id="err_password"></span>
                                        </div>
                                    </div>

               
                                    
                                    <div class="col-xxl-3 col-md-6">
                                        <div class="form-floating">
                                            <button type="submit" id="submitbtn" class="btn btn-success" disabled>Submit</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                            </form>
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
@include("merchant.include.footer");
<script>
    $(document).ready(function(){
        $("#confirm_password").on('keyup',function(){
            var password=$("#password").val();
            var confirm_password=$("#confirm_password").val();
            if(confirm_password==password)
            {
                $("#err_password").html("Password Matched.").css("color","green");
                $("#submitbtn").removeAttr("disabled");
            }
            else{
                $("#err_password").html("Password Does Not Matched.").css("color","red");
                $("#submitbtn").attr("disabled","true");
            }
        })
    })
</script>