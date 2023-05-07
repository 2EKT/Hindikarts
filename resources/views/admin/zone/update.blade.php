@include("admin.include.header");
@include("admin.include.sidebar");
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
    <h4 class="card-title mb-0 flex-grow-1">Update Zone</h4>
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
                                <form action="{{url('/admin/zone/'.$zone->id)}}" method="POST" enctype="multipart/form-data">
                                    {{ method_field('PATCH') }}
                                    @csrf
                                <div class="row gy-4">
                                     <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">State*</label>
                                            <select class="form-control" name="state_id" required>
                                                <option value="">Select State</option>
                                                @php
                                                $state_row=DB::table('state')->get();
                                                @endphp
                                                @foreach($state_row as $state_result)
                                                <option value="{{$state_result->id}}" {{$zone->state_id==$state_result->id?'selected':''}}>{{$state_result->state}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Zone Title*</label>
                                            <input type="text" class="form-control" name="zone_title" placeholder="Zone Title" value="{{$zone->zone_title}}" required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <p>Select Districts : </p>
                                
                     
             
                                <div class="row gy-4">
                                    @php
                                    $district_row=DB::table('district')->where('zone_id','=',0)->orWhere('zone_id','=',$zone->id)->orderBy('district','asc')->get();
                                    @endphp
                                    @foreach ($district_row as $district_result)
                                    <div class="col-xxl-3 col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="district[]" value="{{ $district_result->id }}" {{$zone->id==$district_result->zone_id?'checked':''}}>
                                            <label class="form-check-label" for="exampleCheck1">{{ $district_result->district }}</label>
                                          </div>
                                    </div>
                                    @endforeach
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