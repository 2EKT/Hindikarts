@include("zonal-franchise.include.header");
@include("zonal-franchise.include.sidebar");
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Make Payment</h4>
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
                                <form action="{{ url('/zonal-franchise/make_payment') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-md-4">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Payment Type*</label>
                                            <select class="form-control" name="type" id="type" required>
                                                <option value="">Select Type</option>
                                                <option value="registration">Registration</option>
                                               <option value="Monthly">Monthly</option>
                                                {{--  <option value="advertise">Advertise</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-4 advertisemet-package d-none">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Advertisemet Package*</label>
                                            <select class="form-control" name="advertisement_charge" id="advertisement_charge">
                                                @php
                                                $row=DB::table('advertisement_charges')->get();
                                                @endphp
                                                @foreach ($row as $details)
                                                <option value="{{ $details->id }}">{{ $details->package_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Amount*</label>
                                            <input type="number" step="any" class="form-control" id="amount" name="amount" placeholder="" readonly required>
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
@include("merchant.include.footer");

<script>
    $("#type").on('change',function(){
        getAmount();
    });

    $("#advertisement_charge").on('change',function(){
        getAmount();
    });

   function getAmount(){
            let type=$('#type').val();
            let package=$('#advertisement_charge').val();

            if(type != ''){
                if(type == 'advertise'){
                    $('.advertisemet-package').removeClass('d-none');
                }   
                else{
                    $('.advertisemet-package').addClass('d-none');
                }

                $.ajax({
                    url:"{{ url('/zonal-franchise/get_amount') }}",
                    type:'post',
                    data: {
                         type: type,
                         package: package,
                        _token: "{{ csrf_token() }}"
                    },
                    success:function(data){
                         $('#amount').val(data);
                        //alert(data);
                    }
                  });
            }
    
   }     
</script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>