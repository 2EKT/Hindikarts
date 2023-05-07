@include("admin.include.header");
@include("admin.include.sidebar");
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
    <h4 class="card-title mb-0 flex-grow-1">Update Zone Partner</h4>
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
                                <form action="{{url('/admin/zonepartner/'.$zonepartner->id)}}" method="POST" enctype="multipart/form-data">
                                    {{ method_field('PATCH') }}
                                    @csrf
                                    <div class="row gy-4">
                                   
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Zone*</label>
                                                <select class="form-control" name="zone_id" required>
                                                    <option value="">Select Zone</option>
                                                    @php
                                                    $zone_row=DB::table('zones')->get();
                                                    @endphp
                                                    @foreach ($zone_row as $zone_details)
                                                        <option value="{{ $zone_details->id }}" {{ $zonepartner->zone_id==$zone_details->id?'selected':'' }}>{{ $zone_details->zone_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Name*</label>
                                                <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ $zonepartner->name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Email*</label>
                                                <input type="email" class="form-control" name="email" placeholder="Enter Email" value="{{ $zonepartner->email }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Phone No*</label>
                                                <input type="tel" class="form-control" name="phone" placeholder="Enter Phone" value="{{ $zonepartner->phone }}" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" onkeypress="if(this.value.length==10) return false;"  required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <label for="placeholderInput" class="form-label">New Password</label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input type="password" class="form-control pe-5 password-input" onpaste="return false" name="password"  placeholder="Create Password">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Login Permission*</label>
                                                <select class="form-control" name="active_status" required>
                                                    <option value="">Select</option>
                                                    <option value="YES" {{ $zonepartner->active_status=='YES'?'selected':'' }} >YES</option>
                                                    <option value="NO" {{ $zonepartner->active_status=='NO'?'selected':'' }} >NO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-3 col-md-6 pt-4">
                                            <div class="form-floating">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
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
@include("admin.include.footer");