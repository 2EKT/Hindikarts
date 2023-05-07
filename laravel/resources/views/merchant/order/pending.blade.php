@include("merchant.include.header");
@include("merchant.include.sidebar");

<div id="spinner_loader" style="display:none;"></div>

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">New Order List</h5>
                        
                        </div>
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
                        <div class="card-body">
                            <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Order No</th>
                                        <th>Payment Type</th>
                                        <th>Subtotal</th>
                                        <th>Discount</th>
                                        <th>Delivery Charge</th>
                                        <th>Total Amount</th>
                                        <th>Order Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $order_ids=DB::table('order_items')->where('merchant_id','=',Auth::guard('merchant')->user()->id)->distinct()->pluck('order_id');
                                    $row=DB::table('orders')->where('status','=', 'pending')->whereIn('id', $order_ids)->orderBy('id', 'desc')->get();
                                    @endphp
                                    @foreach ($row as $details)
                                        {{--@php
                                            $cat_row=DB::table('categories')->where('id','=',$details->cat_id)->first();
                                            $subcat_row=DB::table('subcategories')->where('id','=',$details->subcat_id)->first();
                                            $megacat_row=DB::table('megacategories')->where('id','=',$details->megacat_id)->first();
                                        @endphp--}}
                                        <tr id="order_row_{{$details->id}}">
                                            <td>{{$loop->iteration }}</td>
                                            <td>{{$details->order_no}}</td>
                                            <td>{{$details->payment_type}}</td>
                                            <td>{{$details->sub_total}}</td>
                                            <td>{{$details->discount_amount}}</td>
                                            <td>{{$details->delivery_charge}}</td>
                                            <td>{{$details->total_amount}}</td>
                                            <td>{{date('d/m/y g:i A', strtotime($details->created_at))}}</td>
                                            <td>
                                                <button id="accept_btn_{{$details->id}}" class="btn btn-primary accept">Accept</button>
                                                <button id="cancel_btn_{{$details->id}}" class="btn btn-danger cancel">Cancel</button>
                                            </td>
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>

</div>
<!-- container-fluid -->
</div>
<!-- End Page-content -->
@include("merchant.include.footer");

<script>
    function delete_row(id)
    {
       //  alert(id);exit();
        swal({
                 title: "Are you sure?",
                 text: "Once deleted, you will not be able to recover this imaginary file!",
                 icon: "warning",
                 buttons: true,
                 dangerMode: true,
               })
               .then((willDelete) => {
                 if (willDelete) 
                 {
                   document.getElementById("delete_submit"+id).submit();
                 } else 
                 {
                   // swal("Your imaginary file is safe!");
                 }
               });
    } 
   
   </script>

<script>
    $(".accept").on('click',function(){
        let id = $(this).attr('id');
        let order_id = id.replace('accept_btn_', '');     
       
        $('.main-content').addClass('d-none');
        $('#spinner_loader').show();
       
        $.ajax({
            url:"{{ url('merchant/accept-order') }}",
            type:'POST',
            data:{
                _token: "{{ csrf_token() }}",
                order_id: order_id,
            },
            success:function(data){
                let found_delivery_boy = data.data;
                
                if(found_delivery_boy > 0){
                    swal({
                        title: "Success",
                        text: "Notifications sent to the delivery boy",
                        icon: "success",
                        buttons: true,
                    });
                }
                else{
                    swal({
                        title: "Failure",
                        text: "Sorry! No delivery boy found nearby",
                        icon: "warning",
                        buttons: true,
                    });
                }
                $('#spinner_loader').hide();
                $('.main-content').removeClass('d-none');
                }
            });
    });


    $(".cancel").on('click',function(){
              let id = $(this).attr('id');
              let order_id = id.replace('cancel_btn_', '');     

                $('.main-content').addClass('d-none');
                $('#spinner_loader').show();
            
                $.ajax({
                    url:"{{ url('merchant/cancel-order') }}",
                    type:'POST',
                    data:{
                        _token: "{{ csrf_token() }}",
                        order_id: order_id,
                    },
                    success:function(data){
                        swal({
                                title: "Success",
                                text: "Order cancelled successfully",
                                icon: "success",
                                buttons: true,
                            });
                            $('#spinner_loader').hide();
                            $('#order_row_' + order_id).hide();
                            $('.main-content').removeClass('d-none');
                        }
                });
    });




    

</script>