@include("merchant.include.header");
@include("merchant.include.sidebar");
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Product List</h5>
                        
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
                                        <th>Image</th>
                                        <th>Category</th>
                                        <th>Subcategory</th>
                                        <th>Megacategory</th>
                                        <th>Title</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $row=DB::table('products')->where('merchant_id','=',Auth::guard('merchant')->user()->id)->where('active','=','YES')->get();
                                    @endphp
                                    @foreach ($row as $details)
                                        @php
                                            $cat_row=DB::table('categories')->where('id','=',$details->cat_id)->first();
                                            $subcat_row=DB::table('subcategories')->where('id','=',$details->subcat_id)->first();
                                            $megacat_row=DB::table('megacategories')->where('id','=',$details->megacat_id)->first();
                                        @endphp
                                        <tr>
                                            <td>{{$loop->iteration }}</td>
                                            <td><img src="{{ URL::asset('public/product_image/'.$details->main_image) }}" alt="" style="height: 60px;width: 70px;"></td>
                                            <td>{{$cat_row->category}}</td>
                                            <td>{{$subcat_row->subcategory}}</td>
                                            <td>{{$megacat_row->megacategory}}</td>
                                            <td>{{$details->title}}</td>
                                            <td><a href="{{url('/merchant/product/'.$details->id.'/edit')}}"><i data-feather="edit"></i></a></td>
                                            <td><i data-feather="archive" onclick="delete_row({{$details->id}})"></i></td>
                                            <form action="{{url('/merchant/product/'.$details->id)}}" method="post" id="delete_submit{{$details->id}}" style="display:none;">
                                                    {{ method_field('DELETE') }}
                                                        {{csrf_field()}}
                                            </form>
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