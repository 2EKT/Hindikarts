@include("admin.include.header");
@include("admin.include.sidebar");
<style>
    .newclass
    {
        border: 1px dashed #80808096;
        padding: 10px 5px;
        margin-bottom: 10px;
    }
    .newtitle
    {
        background-color: #bbbbab;
        padding-left: 5px;
    }
</style>
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
    <h4 class="card-title mb-0 flex-grow-1">Update Fees</h4>
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
                                <form action="{{url('/admin/monthlyfee/'.$monthlyfee->id)}}" method="POST" enctype="multipart/form-data">
                                    {{ method_field('PATCH') }}
                                    @csrf

                                <div class="newclass">
                                    <p class="newtitle">Zone Partner Section</p>
                                    <div class="row gy-4">
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Registration Fee*</label>
                                                <input type="text" class="form-control" name="zone_reg" placeholder="Registration Fee" value="{{ $monthlyfee->zone_reg }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Monthly Fee*</label>
                                                <input type="text" class="form-control" name="zone_monthly" placeholder="Monthly Fee" value="{{ $monthlyfee->zone_monthly }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="newclass">
                                    <p class="newtitle">District Partner Section</p>
                                    <div class="row gy-4">
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Registration Fee*</label>
                                                <input type="text" class="form-control" name="district_reg" placeholder="Registration Fee" value="{{ $monthlyfee->district_reg }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Monthly Fee*</label>
                                                <input type="text" class="form-control" name="district_monthly" placeholder="Monthly Fee" value="{{ $monthlyfee->district_monthly }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="newclass">
                                    <p class="newtitle">Block Partner Section</p>
                                    <div class="row gy-4">
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Registration Fee*</label>
                                                <input type="text" class="form-control" name="block_reg" placeholder="Registration Fee" value="{{ $monthlyfee->block_reg }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Monthly Fee*</label>
                                                <input type="text" class="form-control" name="block_monthly" placeholder="Monthly Fee" value="{{ $monthlyfee->block_monthly }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="newclass">
                                    <p class="newtitle">Employee Section</p>
                                    <div class="row gy-4">
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Registration Fee*</label>
                                                <input type="text" class="form-control" name="employee_reg" placeholder="Registration Fee" value="{{ $monthlyfee->employee_reg }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Monthly Fee*</label>
                                                <input type="text" class="form-control" name="employee_monthly" placeholder="Monthly Fee" value="{{ $monthlyfee->employee_monthly }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="newclass">
                                    <p class="newtitle">Delivery Boy Section</p>
                                    <div class="row gy-4">
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Registration Fee*</label>
                                                <input type="text" class="form-control" name="delivery_boy_reg" placeholder="Registration Fee" value="{{ $monthlyfee->delivery_boy_reg }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Monthly Fee*</label>
                                                <input type="text" class="form-control" name="delivery_boy_monthly" placeholder="Monthly Fee" value="{{ $monthlyfee->delivery_boy_monthly }}" required>
                                            </div>
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