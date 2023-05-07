@include("admin.include.header");
@include("admin.include.sidebar");
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
    <h4 class="card-title mb-0 flex-grow-1">Update Scheme</h4>
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
                                <form action="{{url('/admin/schemes/'.$scheme->id)}}" method="POST" enctype="multipart/form-data">
                                    {{ method_field('PATCH') }}
                                    @csrf

                                  <div class="row gy-4">
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Name*</label>
                                            <input type="text" class="form-control" name="name" placeholder="name" value="{{ $scheme->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Type*</label>
                                            <select class="form-control" name="type" id="type" required>
                                                <option value="">Select Type</option>
                                                <option value="zone" {{ $scheme->type=='zone'?'selected':'' }}>Zone</option>
                                                <option value="district" {{ $scheme->type=='district'?'selected':'' }}>District</option>
                                                <option value="block" {{ $scheme->type=='block'?'selected':'' }}>Block</option>
                                                <option value="employee" {{ $scheme->type=='employee'?'selected':'' }}>Employee</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Percentage*</label>
                                            <input type="number" step="any" class="form-control" name="percentage" value="{{ $scheme->percentage }}" placeholder="percentage" required>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Amount*</label>
                                            <input type="number" step="any" class="form-control" name="amount" value="{{ $scheme->amount }}" placeholder="Amount" required>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">From Date*</label>
                                            <input type="date" id="from_date" name="from_date" value="{{ $scheme->from_date }}" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">To Date*</label>
                                            <input type="date" id="to_date" name="to_date" value="{{ $scheme->to_date }}" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
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