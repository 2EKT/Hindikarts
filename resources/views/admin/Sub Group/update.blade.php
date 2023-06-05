@include("admin.include.header");
@include("admin.include.sidebar");
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
    <h4 class="card-title mb-0 flex-grow-1">Update Megacategory</h4>
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
                                <form action="{{url('/admin/megacategory/'.$megacategory->id)}}" method="POST" enctype="multipart/form-data">
                                    {{ method_field('PATCH') }}
                                    @csrf
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Category Name*</label>
                                            <select class="form-control" name="cat_id" id="cat_id" required>
                                                <option value="">Select Category</option>
                                                @php
                                                $cat_row=DB::table('categories')->get();
                                                @endphp
                                                @foreach ($cat_row as $cat_details)
                                                <option value="{{ $cat_details->id }}" {{ $megacategory->cat_id==$cat_details->id?'selected':'' }}>{{ $cat_details->category }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Subcategory Name*</label>
                                            <select class="form-control" name="subcat_id" id="subcat_id" required>
                                                @php
                                                $subcategory_row=DB::table('subcategories')->where('cat_id','=',$megacategory->cat_id)->get();
                                                @endphp
                                                @foreach ($subcategory_row as $subcategory_details)
                                                <option value="{{ $subcategory_details->id }}" {{ $megacategory->subcat_id==$subcategory_details->id?'selected':'' }}>{{ $subcategory_details->subcategory }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Sub Group Name*</label>
                                            <input type="text" class="form-control" name="megacategory" placeholder="SubGroup Name" value="{{ $megacategory->megacategory }}" required>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Image</label>
                                            <input type="file" class="form-control" name="image">
                                            <input type="hidden" class="form-control" name="previous_image" value="{{ $megacategory->image }}">
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

<script>
    $("#cat_id").on('change',function(){
            var category=$(this).val();
            // alert(category);
            $("#subcat_id").html("<option value=''>Select Subcategory</option>");
                $.ajax({
                    url:"{{ url('admin/get_subcategory') }}",
                    type:'post',
                    data:'category='+category+'&_token={{ csrf_token() }}',
                    success:function(data){
                          $("#subcat_id").append(data);
                    }
                  });
        })
</script>