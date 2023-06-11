@include("admin.include.header");
@include("admin.include.sidebar");
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
    <h4 class="card-title mb-0 flex-grow-1">Update Sub Group</h4>
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
                                <form action="{{url('/admin/Group/'.$Group->id)}}" method="POST" enctype="multipart/form-data">
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
                                                <option value="{{ $cat_details->id }}" {{ $Group->cat_id==$cat_details->id?'selected':'' }}>{{ $cat_details->category }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Subcategory Name*</label>
                                            <select class="form-control" name="subcat_id" id="subcat_id" required>
                                                @php
                                                $subcategory_row=DB::table('subcategories')->where('id','=',$Group->subcat_id)->get();
                                                @endphp
                                                @foreach ($subcategory_row as $subcategory_details)
                                                <option value="{{ $subcategory_details->id }}" {{ $Group->subcat_id==$subcategory_details->id?'selected':'' }}>{{ $subcategory_details->subcategory }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Megacategory Name*</label>
                                            <select class="form-control" name="megacategory" id="Megcat_id" required>
                                                @php
                                                $megacategory_row=DB::table('megacategories')->where('id','=',$Group->megacategory_id)->get();
                                                @endphp
                                                @foreach ($megacategory_row as $megacategory_row_details)
                                                <option value="{{ $megacategory_row_details->id }}" {{ $Group->megacategory_id==$megacategory_row_details->id?'selected':'' }}>{{ $megacategory_row_details->megacategory}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Segment Name*</label>
                                            <select class="form-control" name="Segment" id="Segment" required>
                                                @php
                                                $Segment_row=DB::table('segments')->where('id','=',$Group->Segment_id)->get();
                                                @endphp
                                                @foreach ($Segment_row as $Segment_row_details)
                                                <option value="{{ $Segment_row_details->id }}" {{ $Group->Segment_id==$Segment_row_details->id?'selected':'' }}>{{$Segment_row_details->Segment}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">SubSegment Name*</label>
                                            <select class="form-control" name="SubSegment" id="SubSegment" required>
                                                @php
                                                $SubSegment_row=DB::table('sub_segments')->where('id','=',$Group->SegmentSub_id	)->get();
                                                @endphp
                                                @foreach (  $SubSegment_row as $Segmentsub_row_details)
                                                <option value="{{ $Segmentsub_row_details->id }}" {{ $Group->SegmentSub_id	==$Segmentsub_row_details->id?'selected':'' }}>{{$Segmentsub_row_details->SegmentSub}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Group Name*</label>
                                            <select class="form-control" name="Group" id="Group" required>
                                                @php
                                                $Group_row=DB::table('groups')->where('id','=',$Group->Group_id)->get();
                                                @endphp
                                                @foreach (  $Group_row as $Group_row_details)
                                                <option value="{{ $Group_row_details->id }}" {{ $Group->Group_id==$Group_row_details->id?'selected':'' }}>{{$Group_row_details->SegmentSub}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Sub Group Name*</label>
                                            <input type="text" class="form-control" name="SubGroup" placeholder="Sub Group Name" value="{{ $Group->Group }}" required>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Image</label>
                                            <input type="file" class="form-control" name="image">
                                            <input type="hidden" class="form-control" name="previous_image" value="{{ $Group->image }}">
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
    $(document).ready(function(){
        $("#cat_id").on('change',function(){
                var category=$(this).val();
                // alert(category);
                $("#subcat_id").html("<option value=''>Select Subcategory</option>");
                    $.ajax({
                        url:"{{ url('admin/SubGroup/get_subcategory') }}",
                        type:'post',
                        data:'category='+category+'&_token={{ csrf_token() }}',
                        success:function(data){
                              $("#subcat_id").append(data);
                        }
                      });
                      
                   
                      
            });
            $("#subcat_id").on('change',function(){
                let mega=$(this).val();
                // alert(category);
                $("#Megcat_id").html("<option value=''>Select Megacategory</option>");
                      $.ajax({
                        url:"{{ url('admin/SubGroup/get_megacategory') }}",
                        type:'post',
                        data:'category='+mega+'&_token={{ csrf_token() }}',
                        success:function(data){
                              $("#Megcat_id").append(data);
                        }
                      });
                      
                   
                      
            });
            $("#Megcat_id").on('change',function(){
                let Segment=$(this).val();
                // alert(category);
                $("#Segment").html("<option value=''>Select Segment</option>");
                      $.ajax({
                        url:"{{ url('admin/SubGroup/get_Segment') }}",
                        type:'post',
                        data:'category='+Segment+'&_token={{ csrf_token() }}',
                        success:function(data){
                              $("#Segment").append(data);
                        }
                      });
                      
                   
                      
            });
            
            $("#Segment").on('change',function(){
                let SubSegment=$(this).val();
                //  alert(SubSegment);
                $("#SubSegment").html("<option value=''>Select Sub Segment</option>");
                      $.ajax({
                        url:"{{ url('admin/SubGroup/get_SubSegment') }}",
                        type:'post',
                        data:'category='+SubSegment+'&_token={{ csrf_token() }}',
                        success:function(data){
                              $("#SubSegment").append(data);
                        }
                      });
                      
                   
                      
            });
            
            $("#SubSegment").on('change',function(){
            let Group=$(this).val();
            //  alert(SubSegment);
            $("#Group").html("<option value=''>Select Group </option>");
                  $.ajax({
                    url:"{{ url('admin/SubGroup/get_Group') }}",
                    type:'post',
                    data:'category='+Group+'&_token={{ csrf_token() }}',
                    success:function(data){
                          $("#Group").append(data);
                    }
                  });
                
               
                  
        });
    
        });
    </script>