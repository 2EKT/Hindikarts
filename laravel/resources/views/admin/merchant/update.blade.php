@include("admin.include.header");
@include("admin.include.sidebar");
@php
    $details=DB::table('merchants')->where('id',$id)->first();
@endphp
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
    <h4 class="card-title mb-0 flex-grow-1">Update Merchant </h4>
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
                                <form action="{{url('/admin/merchant/update')}}" method="POST" enctype="multipart/form-data">
                                    
                                    @csrf
                                    <div class="row gy-4">
                                   
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Name*</label>
                                                <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ $details->name }}" required>
                                                <input type="hidden" class="form-control" name="id" value="{{ $details->id }}">
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Email*</label>
                                                <input type="email" class="form-control" name="email" placeholder="Enter Email" value="{{ $details->email }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Phone No*</label>
                                                <input type="tel" class="form-control" name="phone" placeholder="Enter Phone" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" onkeypress="if(this.value.length==10) return false;" value="{{ $details->phone }}"  required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <label for="placeholderInput" class="form-label">Create Password*</label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input type="password" class="form-control pe-5 password-input" onpaste="return false" name="password"  placeholder="Create Password" >
                                                <input type="hidden" class="form-control pe-5 password-input" onpaste="return false" name="previous_password"  value="{{ $details->password }}">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                <span style="color:red;">Leave it blank for no changes</span>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Login Permission*</label>
                                                <select class="form-control" name="active_status" required>
                                                    <option value="">Select</option>
                                                    <option value="YES" {{ $details->active_status=='YES'?'selected':'' }}>YES</option>
                                                    <option value="NO" {{ $details->active_status=='NO'?'selected':'' }}>NO</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Image</label>
                                                <input type="file" class="form-control" name="image" >
                                                <input type="hidden" class="form-control" name="previous_image" value="{{ $details->image }}"  required>
                                                <span style="color:red;">Max image size 1000kb</span>
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