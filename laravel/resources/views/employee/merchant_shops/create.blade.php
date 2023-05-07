@include("employee.include.header");
@include("employee.include.sidebar");
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Add Merchant Shop</h4>
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
                                <form action="{{ url('/employee/merchant-shops') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Merchants*</label>
                                            <select class="form-control" name="merchant_id" id="merchant_id" required>
                                                <option value="">Select Merchant</option>
                                                @php
                                                  $row=DB::table('merchants')->where(['employer_id' => Auth::guard('employee')->user()->id, 'active_status' => 'YES'])->get();
                                                @endphp
                                                @foreach ($row as $details)
                                                <option value="{{ $details->id }}">{{ $details->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Name*</label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Address*</label>
                                            <input type="text" class="form-control" name="address" placeholder="Enter Address" required>
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Latitude*</label>
                                            <input type="number" step="any" class="form-control" name="lat" placeholder="Enter Latitude" required>
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Longitude*</label>
                                            <input type="number" step="any" class="form-control" name="long" placeholder="Enter Longitude" required>
                                        </div>
                                    </div>

                                    <!-- <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Status*</label>
                                            <select class="form-control" name="status">
                                                 <option value="active">Active</option>
                                                 <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div> -->

                                    <div class="col-xxl-12 col-md-12">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Description*</label>
                                            <textarea id="editor" class="form-control" name="description" required> </textarea>
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

@include("employee.include.footer");

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>